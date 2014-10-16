//
//  AudioPlayer.h
//  utiltyScales
//
//  Created by Stephen Moraco on 12/01/18.
//  Copyright (c) 2012 Iron Sheep Productions, LLC. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <AVFoundation/AVFoundation.h>
#import <AudioToolbox/AudioToolbox.h>

typedef enum {
    APS_UNKNOWN,
    APS_PLAYING,
    APS_PAUSED,
    APS_INTERRUPTED,
    APS_STOPPED,
    APS_STOPPED_WITH_ERROR
} ePlayerState;

#pragma mark ---- Forward Declarations

@protocol AudioPlayerDelegate;

#pragma mark - AudioPlayer Interface Declaration

@interface AudioPlayer : NSObject <AVAudioPlayerDelegate> {
    
}

#pragma mark ---- Properties

@property (nonatomic, readonly, getter=isPlaying) BOOL playing;
@property (nonatomic, readonly, getter=isPaused) BOOL paused;
@property (nonatomic, weak) id<AudioPlayerDelegate> delegate;


#pragma mark ---- Instance Methods

-(void)playSoundFile:(NSString *)filename;
-(void)stopPlaying;
-(void)pausePlaying;
-(void)resumePlaying;

@end

#pragma mark - <AudioPlayerDelegate> Protocol Declaration

@protocol AudioPlayerDelegate <NSObject>
@required
-(void)player:(AudioPlayer *)player stateChanged:(ePlayerState)state;

@end