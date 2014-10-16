//
//  ViewController.m
//  helloAlien
//
//  Created by Rory Lewis on 12/26/11.
//  Copyright (c) 2011 University of Colorado at Colorado Springs. All rights reserved.
//

#import "ViewController.h"

@implementation ViewController

@synthesize lblFindStatus;
@synthesize alienText;

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Release any cached data, images, etc that aren't in use.
}

#pragma mark - View lifecycle

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
    
    // show initial find status
    [self alien:nil saysIAmHere:NO];
}

- (void)viewDidUnload
{
    [self setLblFindStatus:nil];
    [super viewDidUnload];
    // Release any retained subviews of the main view.
    // e.g. self.myOutlet = nil;
}

- (void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
}

- (void)viewDidAppear:(BOOL)animated
{
    [super viewDidAppear:animated];
}

- (void)viewWillDisappear:(BOOL)animated
{
	[super viewWillDisappear:animated];
}

- (void)viewDidDisappear:(BOOL)animated
{
	[super viewDidDisappear:animated];
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    // Return YES for supported orientations
    return (interfaceOrientation != UIInterfaceOrientationPortraitUpsideDown);
}

- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    if ([[segue identifier] isEqualToString:@"ShowAlienView"]) {
        [[segue destinationViewController] setDelegate:self];
        [[segue destinationViewController] setMessageForAlien:self.alienText];
    }
}


// alien identifies itself as existing
-(void)alien:(AlienViewController *)view saysIAmHere:(BOOL)bIsHere
{
    lblFindStatus.text = (bIsHere) ? @"Status: whoa, found aliens!" : @"Status: no aliens found";

}

#pragma mark ---- <UITextFieldDelegate> Methods

- (BOOL)textFieldShouldReturn:(UITextField *)textField
{
	// the user pressed the return, so dismiss the keyboard
	[textField resignFirstResponder];
	return YES;
}

#pragma mark ---- IBAction methods

- (void)textFieldDidEndEditing:(UITextField *)textField

{
        // Capture the new text from out text field
        self.alienText = textField.text;
}


@end
