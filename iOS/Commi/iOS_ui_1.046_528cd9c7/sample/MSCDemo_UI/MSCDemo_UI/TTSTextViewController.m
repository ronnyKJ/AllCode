//
//  TTSTextViewController.m
//  MSC
//
//  Created by iflytek on 13-4-11.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import "TTSTextViewController.h"
#import "iflyMSC/IFlySpeechError.h"

#import <QuartzCore/QuartzCore.h>

@interface TTSTextViewController ()

@end

@implementation TTSTextViewController

- (id) init
{
    if (self = [super init]) {
        
        self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc] initWithTitle:@"设置" style:UIBarButtonItemStylePlain target:self action:@selector(setup)];
        
        _textView = [[UITextView alloc] initWithFrame:CGRectMake(10, 10, 300, 200)];
        _textView.font = [UIFont boldSystemFontOfSize:17];
        
        _textView.layer.cornerRadius = 4.0f;
        _textView.layer.borderWidth = 1.0f;
        _textView.layer.borderColor = [[UIColor colorWithRed:0 green:0 blue:0 alpha:0.5] CGColor];
        _textView.text = SYN_TEXT_SHOW;
        _textView.editable = NO;
        
        _beginButton = [UIButton buttonWithType:UIButtonTypeRoundedRect];
        _beginButton.frame = CGRectMake(10, 250, 280, 50);
        [_beginButton setTitle:@"开始合成" forState:UIControlStateNormal];
        [_beginButton addTarget:self action:@selector(onBegin:) forControlEvents:UIControlEventTouchUpInside];

        NSString *initString = [[NSString alloc] initWithFormat:@"appid=%@",APPID ];
        
        _iFlySynthesizerView = [[IFlySynthesizerView alloc] initWithOrigin:CGPointMake(10, 60) params:initString];
        [initString release];
        _iFlySynthesizerView.delegate = self;
    }
    return self;
}

//-(void) loadView
//{
//    CGRect frame = [[UIScreen mainScreen] applicationFrame];
//    UIView *mainView = [[UIView alloc] initWithFrame:frame];
//    mainView.backgroundColor = [UIColor whiteColor];
//    
//    self.view = mainView;
//}

/*
 * @开始播放
 */
- (void) onBegin:(id) sender
{
    _beginButton.enabled = NO;
//    [_iFlySynthesizerView setParameter:@"params" value:@"bgs=1"];
    [_iFlySynthesizerView startSpeaking:_textView.text];
}

- (void) setup
{
    if (_synthesizerSetupController == nil) {
        _synthesizerSetupController = [[UISynthesizerSetupController alloc] initWithSynthesizer:_iFlySynthesizerView];        
    }
    [self.navigationController pushViewController:_synthesizerSetupController animated:YES];
    
}

- (void)viewDidLoad
{
    self.view.backgroundColor = [UIColor whiteColor];
    [self.view addSubview:_textView];
    [self.view addSubview: _beginButton];
    
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (void) viewDidUnload
{
//    [_iFlySynthesizerView cancel];
    [super viewDidUnload];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

#pragma mark delegate
- (void) onBufferProress:(IFlySynthesizerView *)iFlySynthesizerView progress:(int)progress
{
    NSLog(@"bufferProgress:%d",progress);
}

- (void) onEnd:(IFlySynthesizerView *)iFlySynthesizerView error:(IFlySpeechError *)error
{
    _beginButton.enabled = YES;
}

- (void) onPlayProress:(IFlySynthesizerView *)iFlySynthesizerView progress:(int)progress
{
    NSLog(@"playProgress:%d",progress);
}

@end
