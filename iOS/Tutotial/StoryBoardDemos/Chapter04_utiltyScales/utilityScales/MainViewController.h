//
//  MainViewController.h
//  utilityScales
//
//  Created by Stephen Moraco on 12/06/01.
//  Copyright (c) 2012 Iron Sheep Productions, LLC. All rights reserved.
//

#import "FlipsideViewController.h"
#import "AudioPlayer.h"
#import "PlayButton.h"

@interface MainViewController : UIViewController <FlipsideViewControllerDelegate, UIPopoverControllerDelegate, AudioPlayerDelegate, PlayButtonDelegate>

@property (strong, nonatomic) UIPopoverController *flipsidePopoverController;
@property (weak, nonatomic) IBOutlet UIImageView *ivBackground;
@property (weak, nonatomic) IBOutlet UIView *vwButtonPlace;
@property (weak, nonatomic) IBOutlet UINavigationItem *niTitle;

@end
