//
//  AudioPlayer.m
//  utiltyScales - encapsulate audio playing functions
//
//  Created by Stephen Moraco on 12/01/18.
//  Copyright (c) 2012 Iron Sheep Productions, LLC. All rights reserved.
//

#import "AudioPlayer.h"

#pragma mark AudioPlayer PRIVATE Interface

@interface AudioPlayer () {

}

#pragma mark ---- Properties PRIVATE 

@property (nonatomic, strong) AVAudioPlayer *appSoundPlayer;
@property (nonatomic, readwrite) BOOL interruptedOnPlayback;
@property (nonatomic, readwrite, getter=isPlaying) BOOL playing;
@property (nonatomic, readwrite, getter=isPaused) BOOL paused;
@property (nonatomic, strong) NSURL *soundFileURL;
@property (nonatomic, strong) NSString *soundFileSpec;

#pragma mark ---- Methods PRIVATE 

void audioRouteChangeListenerCallback (
                                       void                      *inUserData,
                                       AudioSessionPropertyID    inPropertyID,
                                       UInt32                    inPropertyValueSize,
                                       const void                *inPropertyValue
                                       );

- (void) setupApplicationAudio;

@end


#pragma mark - AudioPlayer Implementation

@implementation AudioPlayer

#pragma mark ---- Properties Public

@synthesize playing;					// An application that responds to interruptions must keep track of its playing/not-playing state.
@synthesize paused;
@synthesize delegate;

#pragma mark ---- Properties PRIVATE

@synthesize appSoundPlayer;				// An AVAudioPlayer object for playing application sound
@synthesize interruptedOnPlayback;		// A flag indicating whether or not the application was interrupted duringapplication audio playback
@synthesize soundFileURL;				// The path to the current sound file
@synthesize soundFileSpec;

#pragma mark ---- Instance Methods Public

-(id)init
{
    self = [super init];
    if(self)
    {
        [self setupApplicationAudio];
    }
    return self;
}

-(void)playSoundFile:(NSString *)filespec
{
    if(playing)
    {
        [self stopPlaying];
    }
    
    self.soundFileSpec = filespec;
    
	// Converts the sound's file path to an NSURL object
	NSURL *newURL = [[NSURL alloc] initFileURLWithPath:filespec];
	self.soundFileURL = newURL;
    
	// Instantiates the AVAudioPlayer object, initializing it with the sound
	AVAudioPlayer *newPlayer = [[AVAudioPlayer alloc] initWithContentsOfURL: soundFileURL error: nil];
	self.appSoundPlayer = newPlayer;
	
	// "Preparing to play" attaches to the audio hardware and ensures that playback
	//		starts quickly when the user taps Play
	[appSoundPlayer prepareToPlay];
	[appSoundPlayer setVolume: 1.0];
	[appSoundPlayer setDelegate: self];
    
    [appSoundPlayer play];
	playing = YES;
    paused = NO;
    [delegate player:self stateChanged:APS_PLAYING];
}

-(void)stopPlaying
{
    [appSoundPlayer stop];
    playing = NO;
    paused = NO;
    [delegate player:self stateChanged:APS_STOPPED];
}

-(void)pausePlaying
{
    [appSoundPlayer pause];
    paused = YES;
    [delegate player:self stateChanged:APS_PAUSED];
}

-(void)resumePlaying
{
    paused = NO;
    if(playing)
    {
        [appSoundPlayer play];  // tell it to continue
        [delegate player:self stateChanged:APS_PLAYING];
    }
    else
    {
        [self playSoundFile:soundFileSpec];
    }
}


#pragma mark - <AVAudioPlayerDelegate> methods

/* audioPlayerDidFinishPlaying:successfully: is called when a sound has finished playing. This method is NOT called if the player is stopped due to an interruption. */
- (void)audioPlayerDidFinishPlaying:(AVAudioPlayer *)player successfully:(BOOL)flag
{
	playing = NO;
    paused = NO;
    [delegate player:self stateChanged:APS_STOPPED];
}

/* if an error occurs while decoding it will be reported to the delegate. */
- (void)audioPlayerDecodeErrorDidOccur:(AVAudioPlayer *)player error:(NSError *)error
{
	playing = NO;
    paused = NO;
    [delegate player:self stateChanged:APS_STOPPED_WITH_ERROR];
}

/* audioPlayerBeginInterruption: is called when the audio session has been interrupted while the player was playing. The player will have been paused. */
- (void)audioPlayerBeginInterruption:(AVAudioPlayer *)player
{
	NSLog (@"Interrupted. The system has paused audio playback.");
	
	if (playing) {
        
		playing = NO;
        paused = YES;
		interruptedOnPlayback = YES;
        [delegate player:self stateChanged:APS_INTERRUPTED];
	}
}

/* audioPlayerEndInterruption:withFlags: is called when the audio session interruption has ended and this player had been interrupted while playing. */
/* Currently the only flag is AVAudioSessionInterruptionFlags_ShouldResume. */
- (void)audioPlayerEndInterruption:(AVAudioPlayer *)player withFlags:(NSUInteger)flags
{
	NSLog (@"Interruption ended. Resuming audio playback.");
	
	// Reactivates the audio session, whether or not audio was playing
	//		when the interruption arrived.
	[[AVAudioSession sharedInstance] setActive: YES error: nil];
	
	if (interruptedOnPlayback)
    {
		[appSoundPlayer prepareToPlay];
		[appSoundPlayer play];
		playing = YES;
        paused = NO;
		interruptedOnPlayback = NO;
        [delegate player:self stateChanged:APS_PLAYING];
	}
}

#pragma mark ---- Audio session callbacks

// Audio session callback function for responding to audio route changes. If playing 
//		back application audio when the headset is unplugged, this callback pauses 
//		playback and displays an alert that allows the user to resume or stop playback.
//
//		The system takes care of iPod audio pausing during route changes--this callback  
//		is not involved with pausing playback of iPod audio.
void audioRouteChangeListenerCallback (
                                       void                      *inUserData,
                                       AudioSessionPropertyID    inPropertyID,
                                       UInt32                    inPropertyValueSize,
                                       const void                *inPropertyValue
                                       ) 
{
	
	// ensure that this callback was invoked for a route change
	if (inPropertyID != kAudioSessionProperty_AudioRouteChange) return;
    
	// This callback, being outside the implementation block, needs a reference to the
	//		MainViewController object, which it receives in the inUserData parameter.
	//		You provide this reference when registering this callback (see the call to 
	//		AudioSessionAddPropertyListener).
	AudioPlayer *controller = (__bridge AudioPlayer *) inUserData;
	
	// if application sound is not playing, there's nothing to do, so return.
	if (controller.appSoundPlayer.playing == 0 ) {
        
		NSLog (@"Audio route change while application audio is stopped.");
		return;
		
	} else {
        
		// Determines the reason for the route change, to ensure that it is not
		//		because of a category change.
		CFDictionaryRef	routeChangeDictionary = inPropertyValue;
		
		CFNumberRef routeChangeReasonRef =
        CFDictionaryGetValue (
                              routeChangeDictionary,
                              CFSTR (kAudioSession_AudioRouteChangeKey_Reason)
                              );
        
		SInt32 routeChangeReason;
		
		CFNumberGetValue (
                          routeChangeReasonRef,
                          kCFNumberSInt32Type,
                          &routeChangeReason
                          );
		
		// "Old device unavailable" indicates that a headset was unplugged, or that the
		//	device was removed from a dock connector that supports audio output. This is
		//	the recommended test for when to pause audio.
		if (routeChangeReason == kAudioSessionRouteChangeReason_OldDeviceUnavailable) {
            
			[controller.appSoundPlayer pause];
			NSLog (@"Output device removed, so application audio was paused.");
            
			UIAlertView *routeChangeAlertView = 
            [[UIAlertView alloc]	initWithTitle: NSLocalizedString (@"Playback Paused", @"Title for audio hardware route-changed alert view")
                                       message: NSLocalizedString (@"Audio output was changed", @"Explanation for route-changed alert view")
                                      delegate: controller
                             cancelButtonTitle: NSLocalizedString (@"StopPlaybackAfterRouteChange", @"Stop button title")
                             otherButtonTitles: NSLocalizedString (@"ResumePlaybackAfterRouteChange", @"Play button title"), nil];
			[routeChangeAlertView show];
			// release takes place in alertView:clickedButtonAtIndex: method
            
		} else {
            
			NSLog (@"A route change occurred that does not require pausing of application audio.");
		}
	}
}

#pragma mark ---- Application setup

//#if TARGET_IPHONE_SIMULATOR
//#warning *** Simulator mode: iPod library access works only when running on a device.
//#endif

- (void) setupApplicationAudio 
{
	
	// Registers this class as the delegate of the audio session.
	[[AVAudioSession sharedInstance] setDelegate: self];
	
	// The AmbientSound category allows application audio to mix with Media Player
	// audio. The category also indicates that application audio should stop playing 
	// if the Ring/Siilent switch is set to "silent" or the screen locks.
	[[AVAudioSession sharedInstance] setCategory: AVAudioSessionCategoryAmbient error: nil];
    /*
     // Use this code instead to allow the app sound to continue to play when the screen is locked.
     [[AVAudioSession sharedInstance] setCategory: AVAudioSessionCategoryPlayback error: nil];
     
     UInt32 doSetProperty = 0;
     AudioSessionSetProperty (
     kAudioSessionProperty_OverrideCategoryMixWithOthers,
     sizeof (doSetProperty),
     &doSetProperty
     );
     */
    
	// Registers the audio route change listener callback function
	AudioSessionAddPropertyListener (
                                     kAudioSessionProperty_AudioRouteChange,
                                     audioRouteChangeListenerCallback,
                                     (__bridge void *)self
                                     );
    
	// Activates the audio session.
	
	NSError *activationError = nil;
	[[AVAudioSession sharedInstance] setActive: YES error: &activationError];
}


@end
