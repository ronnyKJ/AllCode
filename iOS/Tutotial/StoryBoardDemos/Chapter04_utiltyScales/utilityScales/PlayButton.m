//
//  PlayButton.m
//  utiltyScales - encapsulate play/stop button functionality into single object
//
//  Created by Stephen Moraco on 12/01/18.
//  Copyright (c) 2012 Iron Sheep Productions, LLC. All rights reserved.
//

#import "PlayButton.h"

@interface PlayButton () {

}

@property (nonatomic, assign, getter = isAcoustic) BOOL acoustic;
@property (nonatomic, strong) UIButton *btnPlay;
@property (nonatomic, strong) UILabel *lblButtonText;
@property (nonatomic, strong) UIImageView *ivPlayIcon;

-(void)OnButtonPress:(id)sender;

@end

@implementation PlayButton

@synthesize acoustic;
@synthesize showPlay;
@synthesize delegate;
@synthesize center;

@synthesize btnPlay;
@synthesize lblButtonText;
@synthesize ivPlayIcon;

@synthesize hidden;

-(id)initWithIsAcoustic:(BOOL)isAcoustic
{
    self = [super init];
    if (self) {
        NSLog(@"init");
        // Custom initialization (don't call setters!)
        acoustic = isAcoustic;
        hidden = NO;
        showPlay = YES;
    }
    return self;
}

/*
- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}
 */

- (void)didReceiveMemoryWarning
{
    // Releases the view if it doesn't have a superview.
    [super didReceiveMemoryWarning];
    
    // Release any cached data, images, etc that aren't in use.
}

#pragma mark - View lifecycle

-(void)setCenter:(CGPoint)theCenter
{
    self.view.center = theCenter;
}

-(CGPoint)center
{
    return self.view.center;
}

-(CALayer *)layer
{
    return [self.view layer];
}

// Implement loadView to create a view hierarchy programmatically, without using a nib.
- (void)loadView
{
    NSLog(@"loadView");
    
    // determine assets for our button type
    NSString *imgName = (self.isAcoustic) ? @"icon 80 x 90 acoustic.png" : @"icon 80 x 90 electric.png";
    NSString *lblText = (self.isAcoustic) ? @"Play\nAcoustic" : @"Play\nElectric";
    
    // create our view
    self.view = [[UIView alloc] initWithFrame:CGRectMake(0, 0, 80, 90)];
    self.view.backgroundColor = [UIColor redColor]; // red so we can make sure it's seen if it is
    
    // create our button on our view
    self.btnPlay = [UIButton buttonWithType: UIButtonTypeRoundedRect];
    self.btnPlay.frame = CGRectMake(0, 0, 80, 90);
    [self.btnPlay setBackgroundImage:[UIImage imageNamed:imgName] forState:UIControlStateNormal];
    [self.btnPlay addTarget:self action:@selector(OnButtonPress:) forControlEvents:UIControlEventTouchUpInside];
    [self.view addSubview:self.btnPlay];
    
    // add label over top of button
    self.lblButtonText = [[UILabel alloc] initWithFrame:CGRectMake(5, 8, 70, 40)];
    self.lblButtonText.font = [UIFont boldSystemFontOfSize:16];
    self.lblButtonText.lineBreakMode = UILineBreakModeWordWrap;
    self.lblButtonText.textAlignment = UITextAlignmentCenter;
    self.lblButtonText.numberOfLines = 2;
    self.lblButtonText.textColor = [UIColor whiteColor];
    self.lblButtonText.shadowColor = [UIColor blackColor];
    self.lblButtonText.shadowOffset = CGSizeMake(1, 1);
    self.lblButtonText.backgroundColor = [UIColor clearColor];
    self.lblButtonText.text = lblText;
    [self.view addSubview:self.lblButtonText];
    
    // and play/pause icon on bottom right of button
    self.ivPlayIcon = [[UIImageView alloc] initWithFrame:CGRectMake(50, 60, 26, 26)];
    self.ivPlayIcon.image = [UIImage imageNamed:@"play.png"];
    [self.view addSubview:self.ivPlayIcon];
}

-(void)setShowPlay:(BOOL)bShowPlay
{
    // determine if we need to change our image...
    BOOL bChangeImage = (self.showPlay == bShowPlay) ? NO : YES;
    // set our new value
    showPlay = bShowPlay;
    // if we need to change our image...
    if(bChangeImage)
    {
        // determine image filename
        NSString *imgName = (bShowPlay) ? @"play.png" : @"pause.png";
        // load image from file into our button
        self.ivPlayIcon.image = [UIImage imageNamed:imgName];
    }
}

-(void)setHidden:(BOOL)bHidden
{
    if(self.hidden != bHidden)
    {
        self.btnPlay.hidden = bHidden;
        self.lblButtonText.hidden = bHidden;
        self.ivPlayIcon.hidden = bHidden;
        self.view.hidden = bHidden;
        hidden = bHidden;
    }
}

// Implement viewDidLoad to do additional setup after loading the view, typically from a nib.
- (void)viewDidLoad
{
    NSLog(@"viewDidLoad");
    [super viewDidLoad];
}


- (void)viewDidUnload
{
    [super viewDidUnload];
    // Release any retained subviews of the main view.
    // e.g. self.myOutlet = nil;
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    // Return YES for supported orientations
    return UIInterfaceOrientationIsLandscape(interfaceOrientation);
}

#pragma mark <UIButton> IBAction method

-(void)OnButtonPress:(id)sender
{
    [self.delegate playButtonPressed:self];
}

@end
