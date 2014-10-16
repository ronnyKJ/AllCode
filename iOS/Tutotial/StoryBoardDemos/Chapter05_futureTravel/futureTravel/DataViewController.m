//
//  DataViewController.m
//  futureTravel
//
//  Created by Stephen Moraco on 12/03/31.
//  Copyright (c) 2012 Iron Sheep Productions, LLC. All rights reserved.
//

#import "DataViewController.h"
#import "ModelPageData.h"

@interface DataViewController () {
    
}

-(void)onButtonPress:(UIButton*)sender;
-(void)showHideImageSelectionIndicator:(NSInteger)imageNbr;
-(void)placeImageSelectorButtonAtLocation:(CGPoint)location tag:(NSInteger)tag;
-(void)placeSelectionIndicatorAtLocation:(CGPoint)location label:(NSString*)text;

@end


@implementation DataViewController

@synthesize dataLabel = _dataLabel;
@synthesize ivPageImage = _ivPageImage;
@synthesize dataObject = _dataObject;

static id<DataViewControllerDelegate> s_pDelegate;   // all class-instances see the delegate this way
static NSUInteger s_nSelectedDestinationNumber = 1;

-(id)delegate
{
    return s_pDelegate;
}

-(void)setDelegate:(id)delegate
{
    s_pDelegate = delegate;
}


-(ModelPageData *)pageObject
{
    return self.dataObject;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
}

- (void)viewDidUnload
{
    [self setIvPageImage:nil];
    [super viewDidUnload];
    // Release any retained subviews of the main view.
    self.dataLabel = nil;
}

- (void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    self.ivPageImage.image = [UIImage imageNamed:self.pageObject.filename];
    self.dataLabel.text = self.pageObject.pageTitle;
    
    if(self.pageObject.pageNbr == 2)
    {
        // add special touch objects for this view - when 40,40 inset is used!!!
        [self placeImageSelectorButtonAtLocation:CGPointMake( 50, 100) tag:1];
        [self placeImageSelectorButtonAtLocation:CGPointMake(510,  90) tag:2];
        [self placeImageSelectorButtonAtLocation:CGPointMake(180, 350) tag:3];
        [self placeImageSelectorButtonAtLocation:CGPointMake(610, 350) tag:4];
        
        // when 40,40 inset is used!!!
        [self placeSelectionIndicatorAtLocation:CGPointMake(190,  85) label:@"1"];
        [self placeSelectionIndicatorAtLocation:CGPointMake(660, 100) label:@"2"];
        [self placeSelectionIndicatorAtLocation:CGPointMake(345, 360) label:@"3"];
        [self placeSelectionIndicatorAtLocation:CGPointMake(750, 330) label:@"4"];
        
        [self showHideImageSelectionIndicator:s_nSelectedDestinationNumber];
    }
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    // Return YES for supported orientations (our two landscape forms only)
    return UIInterfaceOrientationIsLandscape(interfaceOrientation);
}
#pragma mark ---- PRIVATE (Utility) Methods

-(void)placeImageSelectorButtonAtLocation:(CGPoint)location tag:(NSInteger)tag
{
    
    UIButton *btnImageTouchPanel = [[UIButton alloc] initWithFrame:CGRectMake(location.x, location.y, 260, 210)];
    btnImageTouchPanel.backgroundColor = [UIColor clearColor];
    //btnImageTouchPanel.backgroundColor = [UIColor redColor];  // TEST, uncomment to see placement
    btnImageTouchPanel.alpha = 0.4;
    [btnImageTouchPanel addTarget:self action:@selector(onButtonPress:) forControlEvents:UIControlEventTouchUpInside];
    btnImageTouchPanel.tag = tag; // touchPanels are [1,2,3,4]
    [self.view addSubview:btnImageTouchPanel];
}

-(void)placeSelectionIndicatorAtLocation:(CGPoint)location label:(NSString*)text
{
    UIButton *btnImageIndicator = [UIButton buttonWithType: UIButtonTypeCustom];
    CGRect newFrame = CGRectMake(location.x, location.y, 168, 128);
    btnImageIndicator.frame = newFrame;
    [btnImageIndicator setBackgroundImage:[UIImage imageNamed:@"LetsGoCloud"] forState:UIControlStateNormal];
    btnImageIndicator.tag = [text intValue] + 10;   // indicators are [11,12,13,14]
                                                  
    btnImageIndicator.userInteractionEnabled = NO;  // not touchable!
    
    [self.view addSubview:btnImageIndicator];
}

-(void)showHideImageSelectionIndicator:(NSInteger)imageNbr
{
    for (NSInteger nViewTag=11; nViewTag<=14; nViewTag++) {
        UIButton *btnIndicator = (UIButton*)[self.view viewWithTag:nViewTag];
        BOOL bShouldHide = (nViewTag == imageNbr + 10) ? NO : YES;
        //bShouldHide = NO; // TEST uncomment to see placement
        btnIndicator.hidden = bShouldHide;
    }
}


-(void)onButtonPress:(UIButton*)sender
{
    s_nSelectedDestinationNumber = sender.tag;
    [self showHideImageSelectionIndicator:s_nSelectedDestinationNumber];
    [self.delegate dataViewControllerSelectedDestination:s_nSelectedDestinationNumber];
}


@end
