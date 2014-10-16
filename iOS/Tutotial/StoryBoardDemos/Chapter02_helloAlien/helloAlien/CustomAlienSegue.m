//
//  CustomAlienSegue.m
//  helloAlien
//
//  Created by Rory Lewis on 12/26/11.
//  Copyright (c) 2011 University of Colorado at Colorado Springs. All rights reserved.
//


#import "CustomAlienSegue.h"


@interface CustomAlienSegue () {
    
}

-(void)finishedFadeOut;
-(void)finishedFadeIn;

@end

@implementation CustomAlienSegue

-(void)perform
{
    // setup our fade to black animation
    [UIView beginAnimations:nil context:nil];   // begins animation block
    [UIView setAnimationDuration:0.75];         // sets animation duration
    
    [UIView setAnimationDelegate:self];         // sets delegate for this block
    [UIView setAnimationDidStopSelector:@selector(finishedFadeOut)];   // calls the finishedFadeOut method when the animation is done	
    [[self sourceViewController] view].alpha = 0.0;                     // Fades the alpha channel to "0.0" over the "0.75" seconds
    [UIView commitAnimations];                  // ends the block and executes it
}

-(void)finishedFadeOut
{
    [[self destinationViewController] view].alpha = 0.0;       // ensure destination not visible
    
    // push our destination view (albeit we can't see it yet...)
    UINavigationController *navController = [[self sourceViewController] navigationController];
    [navController pushViewController:[self destinationViewController] animated:NO]; 
    
    // now animate the view into being seen
    [UIView beginAnimations:nil context:nil];   // begins animation block
    [UIView setAnimationDuration:0.75];          // sets animation duration
    [UIView setAnimationDelegate:self];         // sets delegate for this block
    [UIView setAnimationDidStopSelector:@selector(finishedFadeIn)];   // calls the finishedFading method when the animation 
    [[self destinationViewController] view].alpha = 1.0;   // fades the view to 1.0 alpha over 1.0 seconds
    [UIView commitAnimations];                  // ends the block and executes it
}

-(void)finishedFadeIn
{
    [[self sourceViewController] view].alpha = 1.0;       // ensure that view we left is visible when we press back button
}

@end