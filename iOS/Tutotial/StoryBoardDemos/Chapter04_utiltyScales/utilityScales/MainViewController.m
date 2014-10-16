//
//  MainViewController.m
//  utilityScales
//
//  Created by Stephen Moraco on 12/06/01.
//  Copyright (c) 2012 Iron Sheep Productions, LLC. All rights reserved.
//

#import "MainViewController.h"
#import "Scale.h"
#import "PlayButton.h"


@interface MainViewController () {
    Scale *m_pSelectedScale;
    AudioPlayer *m_pAudioPlayer;
    PlayButton *m_pLastButtonPlayed;
}

@property (strong, nonatomic) PlayButton *btnPlayAcoustic;
@property (strong, nonatomic) PlayButton *btnPlayElectric;

-(void)playButtonsAreHidden:(BOOL)bHide;
- (void)OnAcousticPressed:(id)sender;
- (void)OnElectricPressed:(id)sender;

@end

@implementation MainViewController

@synthesize flipsidePopoverController = _flipsidePopoverController;
@synthesize ivBackground = _ivBackground;
@synthesize vwButtonPlace = _vwButtonPlace;
@synthesize niTitle = _niTitle;
@synthesize btnPlayAcoustic;
@synthesize btnPlayElectric;

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
    
    m_pAudioPlayer = [[AudioPlayer alloc] init];
    m_pAudioPlayer.delegate = self;
    
    m_pLastButtonPlayed = nil;
    
    self.btnPlayAcoustic = [[PlayButton alloc] initWithIsAcoustic:YES];
    self.btnPlayAcoustic.center = CGPointMake(70, 120);
    self.btnPlayAcoustic.delegate = self;
    [self.view addSubview:self.btnPlayAcoustic.view];
    
    self.btnPlayElectric = [[PlayButton alloc] initWithIsAcoustic:NO];
    self.btnPlayElectric.center = CGPointMake(160, 120);
    self.btnPlayElectric.delegate = self;
    [self.view addSubview:self.btnPlayElectric.view];
    
    // round the corners of our buttons...
    CALayer *btnLayer = [self.btnPlayAcoustic layer];
    btnLayer.masksToBounds = YES;
    btnLayer.cornerRadius = 4;
    
    btnLayer = [self.btnPlayElectric layer];
    btnLayer.masksToBounds = YES;
    btnLayer.cornerRadius = 4;
    
    btnLayer = [self.vwButtonPlace layer];
    btnLayer.masksToBounds = YES;
    btnLayer.cornerRadius = 6;
    
    // initially, hide our audio play buttons
    [self playButtonsAreHidden:YES];
}

- (void)viewDidUnload
{
    [self.btnPlayAcoustic removeFromParentViewController];
    [self.btnPlayElectric removeFromParentViewController];
    [self setBtnPlayAcoustic:nil];
    [self setBtnPlayElectric:nil];
    [self setIvBackground:nil];
    [self setVwButtonPlace:nil];
    [self setNiTitle:nil];
    [super viewDidUnload];
    // Release any retained subviews of the main view.
}

-(void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    self.niTitle.title = @"Select a Scale to start --->>>"; 
}

-(void)playButtonsAreHidden:(BOOL)bHide
{
    self.btnPlayElectric.hidden = bHide;
    self.btnPlayAcoustic.hidden = bHide;
    self.vwButtonPlace.hidden = bHide;
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    // Return YES for supported orientations (our two landscape forms only)
    return UIInterfaceOrientationIsLandscape(interfaceOrientation);
}

#pragma mark - Flipside View Controller

- (void)flipsideViewControllerDidFinish:(FlipsideViewController *)controller
{
    // ok, now show our audio play buttons
    [self playButtonsAreHidden:NO];
    [self.flipsidePopoverController dismissPopoverAnimated:YES];
    self.flipsidePopoverController = nil;
}

- (void)flipsideViewController:(FlipsideViewController *)controller selectedScale:(Scale *)scale
{
    NSLog(@"flipsideViewController:selectedScale:");
    // a new? scale was selected...
    
    // if music is playgin, stop it
    if(m_pAudioPlayer.isPlaying)
    {
        [m_pAudioPlayer stopPlaying];
    }
    
    // record the new scale selection
    m_pSelectedScale = scale;
    
    // set the new image
    self.ivBackground.image = m_pSelectedScale.imageForAcousticScale;
    
    // and set our title to reflect new scale selection
    self.niTitle.title = m_pSelectedScale.title;
}

- (void)popoverControllerDidDismissPopover:(UIPopoverController *)popoverController
{
    self.flipsidePopoverController = nil;
}

- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    if ([[segue identifier] isEqualToString:@"showAlternate"]) {
        [[segue destinationViewController] setDelegate:self];
        
        enum eScaleType nType = (m_pSelectedScale == nil) ? ST_UNKNOWN : m_pSelectedScale.type;
        [[segue destinationViewController] setSelectedScaleType:nType];
        
        UIPopoverController *popoverController = [(UIStoryboardPopoverSegue *)segue popoverController];
        self.flipsidePopoverController = popoverController;
        popoverController.delegate = self;
    }
}

- (IBAction)togglePopover:(id)sender
{
    if (self.flipsidePopoverController) {
        [self.flipsidePopoverController dismissPopoverAnimated:YES];
        self.flipsidePopoverController = nil;
    } else {
        [self performSegueWithIdentifier:@"showAlternate" sender:sender];
    }
}

#pragma mark - <AudioPlayerDelegate> methods

-(void)player:(AudioPlayer *)player stateChanged:(ePlayerState)state
{
    NSLog(@"player:stateChanged:%d", state);
    // select possibly new play/pause icon filename
    BOOL bShowPlayImage = NO;
    BOOL bAllStopped = NO;
    switch (state) {
        case APS_PAUSED:
        case APS_INTERRUPTED:
            bShowPlayImage = YES;
            break;
            
        case APS_STOPPED:
        case APS_STOPPED_WITH_ERROR:
            bShowPlayImage = YES;
            bAllStopped = YES;
            break;
            
        default:
            bShowPlayImage = NO;
            break;
    }
    // identify which imageView needs to be updated
    PlayButton *ivPlayPauseIcon = self.btnPlayAcoustic;
    PlayButton *ivOtherPlayPauseIcon = self.btnPlayElectric;
    if(m_pLastButtonPlayed == self.btnPlayElectric)
    {
        ivPlayPauseIcon = self.btnPlayElectric;
        ivOtherPlayPauseIcon = self.btnPlayAcoustic;
    }
    
    // set new image...
    ivPlayPauseIcon.showPlay = bShowPlayImage;
    if(bAllStopped)
    {
        ivOtherPlayPauseIcon.showPlay = bShowPlayImage;
    }
}

#pragma mark - <PlayButtonDelegate> methods

-(void)playButtonPressed:(PlayButton *)sender
{
    if(sender.isAcoustic)
    {
        [self OnAcousticPressed:sender];
    }
    else
    {
        [self OnElectricPressed:sender];
    }
}

- (void)OnAcousticPressed:(id)sender {
    // play scale from acoustic guitar
    if(m_pAudioPlayer.isPaused && m_pLastButtonPlayed == sender)
    {
        [m_pAudioPlayer resumePlaying];
    }
    else if(m_pAudioPlayer.isPlaying && m_pLastButtonPlayed == sender)
    {
        [m_pAudioPlayer pausePlaying];
    }
    else
    {
        m_pLastButtonPlayed = sender;
        self.ivBackground.image = m_pSelectedScale.imageForAcousticScale;
        [m_pAudioPlayer playSoundFile:m_pSelectedScale.acousticScaleFilespec];
    }
}

- (void)OnElectricPressed:(id)sender {
    // play scale from electric guitar
    if(m_pAudioPlayer.isPaused && m_pLastButtonPlayed == sender)
    {
        [m_pAudioPlayer resumePlaying];
    }
    else if(m_pAudioPlayer.isPlaying && m_pLastButtonPlayed == sender)
    {
        [m_pAudioPlayer pausePlaying];
    }
    else
    {
        m_pLastButtonPlayed = sender;
        self.ivBackground.image = m_pSelectedScale.imageForElectricScale;
        [m_pAudioPlayer playSoundFile:m_pSelectedScale.electricScaleFilespec];
    }
}

@end
