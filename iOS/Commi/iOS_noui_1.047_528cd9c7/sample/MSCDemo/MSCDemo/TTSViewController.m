//
//  TTSViewController.m
//  MSCDemo
//
//  Created by iflytek on 13-6-6.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import "TTSViewController.h"
#import <QuartzCore/QuartzCore.h>

@implementation TTSViewController
- (id) init
{
    self = [super init];
    if (!self) {
        return nil;
    }

    NSString *initString = [[NSString alloc] initWithFormat:@"appid=%@",APPID];
    _iFlySpeechSynthesizer = [[IFlySpeechSynthesizer createWithParams:initString delegate:self] retain];
    _iFlySpeechSynthesizer.delegate = self;
    
    // 设置语音合成的参数
    [_iFlySpeechSynthesizer setParameter:@"speed" value:@"50"];//合成的语速,取值范围 0~100
    [_iFlySpeechSynthesizer setParameter:@"volume" value:@"50"];//合成的音量;取值范围 0~100
    //发音人,默认为”xiaoyan”;可以设置的参数列表可参考个 性化发音人列表;
    [_iFlySpeechSynthesizer setParameter:@"voice_name" value:@"xiaoyan"];   
    [_iFlySpeechSynthesizer setParameter:@"sample_rate" value:@"8000"];//音频采样率,目前支持的采样率有 16000 和 8000;
    
    [initString release];
    _cancelAlertView =  [[AlertView alloc]initWithFrame:CGRectMake(100, 300, 0, 0)];
    _bufferAlertView =  [[AlertView alloc]initWithFrame:CGRectMake(100, 300, 0, 0)];
    return self;
}

- (void)didReceiveMemoryWarning
{
    // Releases the view if it doesn't have a superview.
    [super didReceiveMemoryWarning];
    
    // Release any cached data, images, etc that aren't in use.
}

#pragma mark - View lifecycle


// Implement loadView to create a view hierarchy programmatically, without using a nib.
- (void)loadView
{
    //adjust the UI for iOS 7
#if __IPHONE_OS_VERSION_MAX_ALLOWED >= 70000
    if ( IOS7_OR_LATER )
    {
        self.edgesForExtendedLayout = UIRectEdgeNone;
        self.extendedLayoutIncludesOpaqueBars = NO;
        self.modalPresentationCapturesStatusBarAppearance = NO;
        self.navigationController.navigationBar.translucent = NO;
    }
#endif
    
    CGRect frame = [[UIScreen mainScreen] applicationFrame];
    UIView *mainView = [[UIView alloc] initWithFrame:frame];
    mainView.backgroundColor = [UIColor whiteColor];
    if (!self) {
        return;
    }
    self.view = mainView;
    [mainView release];
    self.title = @"语音合成";
    self.view.backgroundColor = [UIColor whiteColor];
    int height;
    height = self.view.frame.size.height - ButtonHeight*2 - Margin*4-NavigationBarHeight-3;
    _toBeSynthersedTextView = [[UITextView alloc] initWithFrame:
                              CGRectMake(Margin*2, Margin*2, self.view.frame.size.width-Margin*4, height)];
    _toBeSynthersedTextView.layer.cornerRadius = 8;
    _toBeSynthersedTextView.layer.borderWidth = 1;
    _toBeSynthersedTextView.font = [UIFont systemFontOfSize:17.0f];
    _toBeSynthersedTextView.text = @"       科大讯飞作为中国最大的智能语音技术提供商，在智能语音技术领域有着长期的研究积累、\
    并在中文语音合成、语音识别、口语评测等多项技术上拥有国际领先的成果。科大讯飞是我国唯一以语音技术为产业化方\
    向的“国家863计划成果产业化基地”、“国家规划布局内重点软件企业”、“国家火炬计划重点高新技术企业”、\
    “国家高技术产业化示范工程”，并被信息产业部确定为中文语音交互技术标准工作组组长单位，\
    牵头制定中文语音技术标准。2003年，科大讯飞获迄今中国语音产业唯一的“国家科技进步奖（二等）”，\
    2005年获中国信息产业自主创新最高荣誉“信息产业重大技术发明奖”。2006年至2009年，\
    连续四届英文语音合成国际大赛（Blizzard Challenge ）荣获第一名。2008年获国际说话人识别评测大赛\
    （美国国家标准技术研究院—NIST 2008）桂冠，2009年获得国际语种识别评测大赛（NIST 2009）高难度混淆方言\
    测试指标冠军、通用测试指标亚军";
    _toBeSynthersedTextView.textAlignment = UITextAlignmentLeft;
    _textViewHeight = _toBeSynthersedTextView.frame.size.height;
    //_toBeSynthersedTextView.autoresizingMask = UIViewAutoresizingFlexibleHeight;
    
    //键盘
    UIBarButtonItem *spaceBtnItem= [[ UIBarButtonItem alloc] initWithBarButtonSystemItem:UIBarButtonSystemItemFlexibleSpace target:nil action:nil];
    UIBarButtonItem * hideBtnItem = [[UIBarButtonItem alloc] initWithTitle:@"隐藏" style:UIBarStyleBlackOpaque target:self action:@selector(onKeyBoardDown:)];
    UIToolbar * toolbar = [[ UIToolbar alloc]initWithFrame:CGRectMake(0, 0, self.view.frame.size.width, 44)];
    toolbar.barStyle = UIBarStyleBlackTranslucent;
    NSArray * array = [NSArray arrayWithObjects:spaceBtnItem,hideBtnItem, nil];
    [toolbar setItems:array];
    _toBeSynthersedTextView.inputAccessoryView = toolbar;
    [toolbar release];
    [hideBtnItem release];
    [spaceBtnItem release];
    [self.view addSubview:_toBeSynthersedTextView];
    //[_toBeSynthersedTextView sizeToFit];
    
    //开始合成
    UIButton*  startBtn = [UIButton buttonWithType:UIButtonTypeRoundedRect];
    [startBtn setTitle:@"开始合成" forState:UIControlStateNormal];
    int startBtnTop;
    startBtnTop = _toBeSynthersedTextView.frame.size.height + _toBeSynthersedTextView.frame.origin.y + Margin;
    startBtn.frame = CGRectMake(Padding, startBtnTop, (self.view.frame.size.width-Padding*3)/2, ButtonHeight);
    [self.view addSubview:startBtn];
    [startBtn addTarget:self action:@selector(onStart:) forControlEvents:UIControlEventTouchUpInside];
    _startBtn =[startBtn retain];
    
    //取消 
    _cancelBtn = [[UIButton buttonWithType:UIButtonTypeRoundedRect] retain];
    [_cancelBtn setTitle:@"取消" forState:UIControlStateNormal];
    _cancelBtn.frame = CGRectMake(startBtn.frame.origin.x+ Padding +  startBtn.frame.size.width, startBtn.frame.origin.y, startBtn.frame.size.width ,startBtn.frame.size.height);
    [self.view addSubview: _cancelBtn];  
   [_cancelBtn addTarget:self action:@selector(onCancel:) forControlEvents:UIControlEventTouchUpInside];
    _cancelBtn.enabled = NO;
    
    //暂停播放
    _pauseBtn= [[UIButton buttonWithType:UIButtonTypeRoundedRect] retain];
    [_pauseBtn setTitle:@"暂停播放" forState:UIControlStateNormal];
    _pauseBtn.frame = CGRectMake(Padding, startBtn.frame.origin.y + startBtn.frame.size.height + Margin, (self.view.frame.size.width-Padding*3)/2, ButtonHeight);
    [self.view addSubview:_pauseBtn];
    [_pauseBtn addTarget:self action:@selector(onPause:) forControlEvents:UIControlEventTouchUpInside];
    _pauseBtn.enabled = NO;
    
    //恢复播放
    _resumeBtn = [[UIButton buttonWithType:UIButtonTypeRoundedRect] retain];
    [_resumeBtn setTitle:@"继续播放" forState:UIControlStateNormal];
    _resumeBtn.frame = CGRectMake(_pauseBtn.frame.origin.x+ Padding + _pauseBtn.frame.size.width, _pauseBtn.frame.origin.y, _pauseBtn.frame.size.width, _pauseBtn.frame.size.height);
    [self.view addSubview:_resumeBtn]; 
    [_resumeBtn addTarget:self action:@selector(onResume:) forControlEvents:UIControlEventTouchUpInside];
    _resumeBtn.enabled = NO;
    
    _popUpView = [[PopupView alloc]initWithFrame:CGRectMake(100, 300, 0, 0)];
    _popUpView.ParentView = self.view;
}

-(void) viewDidDisappear:(BOOL)animated
{
    _isViewDidDisappear = true;
    [_iFlySpeechSynthesizer stopSpeaking];
}

/*
 * @隐藏键盘
 */
-(void)onKeyBoardDown:(id) sender
{
    [_toBeSynthersedTextView resignFirstResponder];
}

/*
// Implement viewDidLoad to do additional setup after loading the view, typically from a nib.
- (void)viewDidLoad
{
    [super viewDidLoad];
}
*/

- (void)viewDidUnload
{
    [super viewDidUnload];
    //[_iFlySpeechSynthesizer stopSpeaking];
    // Release any retained subviews of the main view.
    // e.g. self.myOutlet = nil;
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    // Return YES for supported orientations
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}

-(void)keyboardWillShow:(NSNotification *)aNotification {
        [self setViewSize:YES Notification:aNotification];
}

-(void)keyboardWillHide :(NSNotification *)aNotification{
    [self setViewSize:NO Notification:aNotification ];
}


//method to change the size of view whenever the keyboard is shown/dismissed
-(void)setViewSize:(BOOL)show Notification:(NSNotification*) notification
{
    [UIView beginAnimations:nil context:NULL];
    [UIView setAnimationDuration:0.3]; // if you want to slide up the view
    
    //获取键盘的高度
    NSDictionary *userInfo = [notification userInfo];
    int height = [[userInfo objectForKey:UIKeyboardFrameEndUserInfoKey] CGRectValue].size.height;
    
    CGRect rect = _toBeSynthersedTextView.frame;
    if (show) {
        rect.size.height = self.view.frame.size.height - height- Margin*4;
    }
    else
    {
        rect.size.height = _textViewHeight;
    }
    _toBeSynthersedTextView.frame = rect;
    
    [UIView commitAnimations];
}


- (void)viewWillAppear:(BOOL)animated
{
    // register for keyboard notifications
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(keyboardWillShow:)
                                                 name:UIKeyboardWillShowNotification
                                               object:nil];
    
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(keyboardWillHide:)
                                                 name:UIKeyboardWillHideNotification
                                               object:nil];
}

- (void)viewWillDisappear:(BOOL)animated
{
    // unregister for keyboard notifications while not visible.
    [[NSNotificationCenter defaultCenter] removeObserver:self
                                                    name:UIKeyboardWillShowNotification
                                                  object:nil];
    
    [[NSNotificationCenter defaultCenter] removeObserver:self
                                                    name:UIKeyboardWillHideNotification
                                                  object:nil];
}

- (void) dealloc
{
    
    [_iFlySpeechSynthesizer setDelegate:nil];
    [_startBtn release];
    [_cancelBtn release];
    [_pauseBtn release];
    [_resumeBtn release];
    [_toBeSynthersedTextView release];
    [_iFlySpeechSynthesizer release];
    [_popUpView release];
    [_cancelAlertView release];
    _cancelAlertView = nil;
    [_bufferAlertView release];
    _bufferAlertView = nil;
    [super dealloc];

}

#pragma mark - Button Handler
/*
 * @开始播放
 */
- (void) onStart:(id) sender
{
    _startBtn.enabled = NO;
    _hasError = NO;
    [NSThread sleepForTimeInterval:0.05];
    [NSThread detachNewThreadSelector:@selector(startSpeaking:) toTarget:self withObject:nil];
    _bufferAlertView.ParentView = self.view;
    [_bufferAlertView setText: @"正在缓冲..."];
    [_popUpView removeFromSuperview];
    [self.view addSubview:_bufferAlertView];
    _cancelBtn.enabled = YES;
    _isCancel = NO;
}

-(void)startSpeaking:(NSString*)text
{
    [_iFlySpeechSynthesizer startSpeaking:_toBeSynthersedTextView.text];
}


/*
 * @ 暂停播放
 */
- (void) onPause:(id) sender
{
    if (_hasError) {
        return;
    }
    [_iFlySpeechSynthesizer pauseSpeaking];
    _resumeBtn.enabled = YES;
    _pauseBtn.enabled = NO;
}

/*
 * @恢复播放
 */
- (void) onResume:(id) sender
{
    if (_hasError) {
        return;
    }
    [_iFlySpeechSynthesizer resumeSpeaking];
    _resumeBtn.enabled = NO;
    _pauseBtn.enabled = YES;
}

/*
 * @取消播放
 */
- (void) onCancel:(id) sender
{
    [_iFlySpeechSynthesizer stopSpeaking];
    _cancelBtn.enabled = NO;
    _pauseBtn.enabled = NO;
    _resumeBtn.enabled = NO;
}

#pragma mark - IFlySpeechSynthesizerDelegate

/**
 * @fn      onSpeakBegin
 * @brief   开始播放
 *
 * @see
 */
- (void) onSpeakBegin
{
    [_bufferAlertView dismissModalView];
    [_cancelAlertView dismissModalView];
    _isCancel = NO;
    [_popUpView setText:@"开始播放"];
    [self.view addSubview:_popUpView];
    _pauseBtn.enabled = YES;
    _resumeBtn.enabled = NO;
    _cancelBtn.enabled = YES;
}

/**
 * @fn      onBufferProgress
 * @brief   缓冲进度
 *
 * @param   progress            -[out] 缓冲进度
 * @param   msg                 -[out] 附加信息
 * @see
 */
- (void) onBufferProgress:(int) progress message:(NSString *)msg
{
    NSLog(@"bufferProgress:%d,message:%@",progress,msg);    
}

/**
 * @fn      onSpeakProgress
 * @brief   播放进度
 *
 * @param   progress            -[out] 播放进度
 * @see
 */
- (void) onSpeakProgress:(int) progress
{
    NSLog(@"play progress:%d",progress);
}

/**
 * @fn      onSpeakPaused
 * @brief   暂停播放
 *
 * @see
 */
- (void) onSpeakPaused
{
    _pauseBtn.enabled = NO;
    _resumeBtn.enabled = YES;
    [_popUpView setText:@"播放暂停"];
    [self.view addSubview:_popUpView];
}

/**
 * @fn      onSpeakResumed
 * @brief   恢复播放
 *
 * @see
 */
- (void) onSpeakResumed
{
    _resumeBtn.enabled = NO;
    _pauseBtn.enabled = YES;
    [_popUpView setText:@"播放继续"];
    [self.view addSubview:_popUpView];
}

/**
 * @fn      onCompleted
 * @brief   结束回调
 *
 * @param   error               -[out] 错误对象
 * @see
 */
- (void) onCompleted:(IFlySpeechError *) error
{
    NSString *text ;
    if (_isCancel) {
        
        text = @"合成已取消";
    }
    else if (error.errorCode ==0 ) {
        text = @"合成结束";
        //_resultView.text = _result;
    }
    else
    {
        text = [NSString stringWithFormat:@"发生错误：%d %@",error.errorCode,error.errorDesc];
        _hasError = YES;
        NSLog(@"%@",text);
    }
    [_cancelAlertView dismissModalView];
    [_bufferAlertView dismissModalView];
    [self performSelectorOnMainThread:@selector(setpopUpView:) withObject:text waitUntilDone:NO];
   
    _startBtn.enabled = YES;
    _pauseBtn.enabled = NO;
    _cancelBtn.enabled = NO;
    _resumeBtn.enabled = NO;
}

-(void) setpopUpView:(NSString*) text
{
    [_popUpView setText: text];
    [self.view addSubview:_popUpView];
}

/**
 * @fn      onSpeakCancel
 * @brief   正在取消
 *
 * @see
 */
- (void) onSpeakCancel
{
    if (_isViewDidDisappear) {
        return;
    }
    _isCancel = YES;
    [_bufferAlertView dismissModalView];
    _cancelAlertView.ParentView = self.view;
    [_cancelAlertView setText: @"正在取消..."];
    [_popUpView removeFromSuperview];
    [self.view addSubview:_cancelAlertView];
}


@end
