//
//  ISRTextViewController.m
//  MSC
//
//  Created by iflytek on 13-4-7.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import "ISRTextViewController.h"
//#import "ISRSetupViewController.h"

#import <QuartzCore/QuartzCore.h>
#import "AppDelegate.h"
@interface ISRTextViewController ()

@end

@implementation ISRTextViewController


- (id) init
{
    if (self = [super init]) {
        CGRect frame = [[UIScreen mainScreen] applicationFrame];
        _isrTextView = [[ISRTextView alloc] initWithFrame:frame];
        
        _isrTextView.ent = @"sms";
    }
    
    return self;
}


-(void) loadView
{
    self.view = _isrTextView;
}

- (void)viewDidLoad
{
    
}

- (void) viewDidAppear:(BOOL)animated
{

}
- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


#pragma mark -- delegate

- (void) dealloc
{
    NSLog(@"isrTextView dealloc");
    [super dealloc];
}
@end
