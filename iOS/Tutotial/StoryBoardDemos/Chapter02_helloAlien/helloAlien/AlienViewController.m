//
//  AlienViewController.m
//  helloAlien
//
//  Created by Rory Lewis on 12/26/11.
//  Copyright (c) 2011 University of Colorado at Colorado Springs. All rights reserved.
//

#import "AlienViewController.h"

@implementation AlienViewController

@synthesize delegate;
@synthesize messageForAlien;
@synthesize lblmessageForAlien;


- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)didReceiveMemoryWarning
{
    // Releases the view if it doesn't have a superview.
    [super didReceiveMemoryWarning];
    
    // Release any cached data, images, etc that aren't in use.
}

#pragma mark - View lifecycle

/*
// Implement loadView to create a view hierarchy programmatically, without using a nib.
- (void)loadView
{
}
*/

/*
// Implement viewDidLoad to do additional setup after loading the view, typically from a nib.
- (void)viewDidLoad
{
    [super viewDidLoad];
}
*/

-(void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    
    // preset to switch is off
    m_bIsAlienSeen = NO;
    
    // place given text on screen
    lblmessageForAlien.text = self.messageForAlien;
}

-(void)viewWillDisappear:(BOOL)animated
{
    [super viewWillDisappear:animated];
    
    // tell our delegate of our ending state
    [self.delegate alien:self saysIAmHere:m_bIsAlienSeen];
}



- (void)viewDidUnload
{
    [self setLblmessageForAlien:nil];
    [super viewDidUnload];
    // Release any retained subviews of the main view.
    // e.g. self.myOutlet = nil;
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    // Return YES for supported orientations
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}


- (IBAction)onSwitchValueChanged:(id)sender 
{
    // switch changed values get the new value and save it
    UISwitch *theSwitch = sender;
    m_bIsAlienSeen = theSwitch.isOn;
}
@end
