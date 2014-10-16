//
//  ABNFViewController.m
//  MSCDemo
//
//  Created by iflytek on 13-6-6.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import "ABNFViewController.h"
#import <QuartzCore/QuartzCore.h>
#import "Definition.h"
#import "RecognizerFactory.h"
#define kOFFSET_FOR_KEYBOARD 110.0
@implementation ABNFViewController

static NSString * _grammerId = nil;

-(void) setGrammerId:(NSString*) id
{
    [_grammerId release];
    _grammerId = [id retain];
    [_iFlySpeechRecognizer setParameter:@"grammarID" value:_grammerId];
}

- (id) init
{
    self = [super init];
    if (!self) {
        return nil;
    }
    _iFlySpeechRecognizer = [[RecognizerFactory CreateRecognizer:self Domain:@"asr"] retain];
    _result = [[NSMutableString alloc] init];
    _isCancled = NO;
    _uploader = [[IFlyDataUploader alloc] initWithDelegate:nil pwd:nil params:nil delegate:self];
    return self;
}

- (void)didReceiveMemoryWarning
{
    // Releases the view if it doesn't have a superview.
    [super didReceiveMemoryWarning];
    
    // Release any cached data, images, etc that aren't in use.
}

#pragma mark - Button handler
/*
 * @ 开始录音
 */
- (void) onBtnStart:(id)sender
{
    if (_grammerId == nil) {
        [_popUpView setText:@"   请先上传\
             语法"];
        [self.view addSubview:_popUpView];
        
        return;
    }
    [_iFlySpeechRecognizer setParameter:@"grammarID" value:_grammerId];
    BOOL ret = [_iFlySpeechRecognizer startListening];
    if (ret) {
        _isCancled = NO;
    }
    else
    {
        [_popUpView setText: @"启动识别服务失败，请稍后重试"];//可能是上次请求未结束
        [self.view addSubview:_popUpView];
    }
    [_curResult release];
    _curResult = nil;
}

/*
 * @ 暂停录音
 */
- (void) onBtnStop:(id) sender
{
    [_iFlySpeechRecognizer stopListening];
    [_resultView resignFirstResponder];
}

/*
 * @取消识别
 */
- (void) onBtnCancel:(id) sender
{
    _isCancled = YES;
    [_iFlySpeechRecognizer cancel];
    [_resultView resignFirstResponder];
}

/*
 * @ 上传语法
 */
- (void) onBtnUpload:(id)sender
{
    [_iFlySpeechRecognizer stopListening];
    _uploadBtn.enabled = NO;
    /*上传abnf语法时，需要上传的参数*/
    #define ABNF        @"subject=asr,dtt=abnf"
    #define ABNFDATA    @"#ABNF 1.0 UTF-8;\n            \
    language zh-CN;\n               \
    mode voice;\n                   \
    root $main;\n                   \
    $main = $place1 到 $place2;\n    \
    $place1 = 北京 | 武汉 | 南京 | 天津 | 天京 |东京;\n \
    $place2 = 上海 | 合肥;\n\
    "
    
    #define ABNFNAME        @"abnf" //名称可以自定义
    [self showPopup];
    [_uploader uploadData:ABNFNAME params:ABNF data:ABNFDATA];
}

#pragma mark - IFlySpeechRecognizerDelegate
/**
 * @fn      onVolumeChanged
 * @brief   音量变化回调
 *
 * @param   volume      -[in] 录音的音量，音量范围1~100
 * @see
 */
- (void) onVolumeChanged: (int)volume
{
    NSString * vol = [NSString stringWithFormat:@"音量：%d",volume];
    [_popUpView setText: vol];
    [self.view addSubview:_popUpView];
}

/**
 * @fn      onBeginOfSpeech
 * @brief   开始识别回调
 *
 * @see
 */
- (void) onBeginOfSpeech
{
    [_popUpView setText: @"正在录音"];
    [self.view addSubview:_popUpView];
}

/**
 * @fn      onEndOfSpeech
 * @brief   停止录音回调
 *
 * @see
 */
- (void) onEndOfSpeech
{
    [_popUpView setText: @"停止录音"];
    [self.view addSubview:_popUpView];
}

/**
 * @fn      onError
 * @brief   识别结束回调
 *
 * @param   errorCode   -[out] 错误类，具体用法见IFlySpeechError
 */
- (void) onError:(IFlySpeechError *) error
{
    NSString *text ;
    if (_isCancled) {
        text = @"识别取消";
    }
    else if (error.errorCode ==0 ) {
        if (_curResult.length==0) {
            text = @"无匹配结果";
        }
        else
        {
            text = @"识别成功";
            [_result appendString:_curResult];
            _resultView.text = _result;
        }
    }
    else
    {
        text = [NSString stringWithFormat:@"发生错误：%d %@",error.errorCode,error.errorDesc];
        NSLog(@"%@",text);
    }
    [_popUpView setText: text];
    [self.view addSubview:_popUpView];
}

/**
 * @fn      onResults
 * @brief   识别结果回调
 * 
 * @param   result      -[out] 识别结果，NSArray的第一个元素为NSDictionary，NSDictionary的key为识别结果，value为置信度
 * @see
 */
- (void) onResults:(NSArray *) results
{
    NSMutableString *result = [[NSMutableString alloc] init];
    NSDictionary *dic = [results objectAtIndex:0];
    for (NSString *key in dic) {
        id value = [dic objectForKey:key];
        [result appendFormat:@"%@ (置信度:%@)\n",key,value];
    }
    if (_curResult == nil  ) {
        _curResult =  [[NSMutableString alloc] init];
    }
    [_curResult appendString:result];
    [result release];
}

/**
 * @fn      onCancal
 * @brief   取消识别回调
 *
 * @see
 */

- (void) onCancel
{
    [_popUpView setText: @"正在取消"];
    [self.view addSubview:_popUpView];
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
    self.view = mainView;
    [mainView release];
    self.title = @"语法识别";
    self.view.backgroundColor = [UIColor whiteColor];
    
    //Result view
    int height;
    height = self.view.frame.size.height - ButtonHeight*2 - Margin*8-NavigationBarHeight;
    UITextView *resultView = [[UITextView alloc] initWithFrame:
                              CGRectMake(Margin*2, Margin*2, self.view.frame.size.width-Margin*4, height)];
    resultView.layer.cornerRadius = 8;
    resultView.layer.borderWidth = 1;
    resultView.text = @"开始识别前请先点击“上传”按钮上传语法。\n\t上传内容为：\n\t#ABNF 1.0 gb2312;\n\tlanguage zh-CN;\n\tmode voice;\n\troot $main;\n\t$main = $place1 到$place2 ;\n\t$place1 = 北京 | 武汉 | 南京 | 天津 | 天京 | 东京;\n\t$place2 = 上海 | 合肥";
    resultView.font = [UIFont systemFontOfSize:17.0f];
    
    resultView.pagingEnabled = YES;
    UIEdgeInsets aUIEdge = [resultView contentInset]; 
    aUIEdge.left = 10;
    aUIEdge.right = 10;
    aUIEdge.top = 10;
    aUIEdge.bottom = 10;
    resultView.contentInset = aUIEdge;
    [resultView setEditable:NO];
    //[resultView sizeToFit];
    
    //键盘
    UIBarButtonItem *spaceBtnItem= [[ UIBarButtonItem alloc] initWithBarButtonSystemItem:UIBarButtonSystemItemFlexibleSpace target:nil action:nil];
    UIBarButtonItem * hideBtnItem = [[UIBarButtonItem alloc] initWithTitle:@"隐藏" style:UIBarStyleBlackOpaque target:self action:@selector(onKeyBoardDown:)];
    UIToolbar * toolbar = [[ UIToolbar alloc]initWithFrame:CGRectMake(0, 0, self.view.frame.size.width, 44)];
    toolbar.barStyle = UIBarStyleBlackTranslucent;
    NSArray * array = [NSArray arrayWithObjects:spaceBtnItem,hideBtnItem, nil];
    [toolbar setItems:array];
    //resultView.inputAccessoryView = toolbar;
    [toolbar release];
    [hideBtnItem release];
    [spaceBtnItem release];
    [self.view addSubview:resultView];
    _resultView = [resultView retain];
    
    //命令词上传
    UIButton *uploadBtn = [UIButton buttonWithType:UIButtonTypeRoundedRect];
    [uploadBtn setTitle:@"语法上传" forState:UIControlStateNormal];
    uploadBtn.frame = CGRectMake(Padding, resultView.frame.origin.y + resultView.frame.size.height + Margin*2, (self.view.frame.size.width-Padding*3)/2, ButtonHeight);
    [self.view addSubview:uploadBtn];
    [uploadBtn addTarget:self action:@selector(onBtnUpload:) forControlEvents:UIControlEventTouchUpInside];
    _uploadBtn = [uploadBtn retain];
    
    //开始识别
    UIButton *startBtn = [UIButton buttonWithType:UIButtonTypeRoundedRect];
    [startBtn setTitle:@"开始" forState:UIControlStateNormal];
    startBtn.frame = CGRectMake(uploadBtn.frame.origin.x+ Padding + uploadBtn.frame.size.width, uploadBtn.frame.origin.y, uploadBtn.frame.size.width, uploadBtn.frame.size.height);
    [self.view addSubview:startBtn];
    _startBtn = [startBtn retain];
    [_startBtn addTarget:self action:@selector(onBtnStart:) forControlEvents:UIControlEventTouchUpInside];
    
    //停止识别
    UIButton *stopBtn = [UIButton buttonWithType:UIButtonTypeRoundedRect];
    [stopBtn setTitle:@"停止" forState:UIControlStateNormal];
    stopBtn.frame = CGRectMake(Padding, startBtn.frame.origin.y + startBtn.frame.size.height + Margin, (self.view.frame.size.width-Padding*3)/2, ButtonHeight);
    [self.view addSubview:stopBtn];
    _stopBtn = [stopBtn retain];
    [_stopBtn addTarget:self action:@selector(onBtnStop:) forControlEvents:UIControlEventTouchUpInside];
    
    //取消
    UIButton *cancelBtn = [UIButton buttonWithType:UIButtonTypeRoundedRect];
    [cancelBtn setTitle:@"取消" forState:UIControlStateNormal];
    cancelBtn.frame = CGRectMake(stopBtn.frame.origin.x+ Padding + stopBtn.frame.size.width, stopBtn.frame.origin.y, stopBtn.frame.size.width, stopBtn.frame.size.height);
    [self.view addSubview:cancelBtn];  
    _cancelBtn = [cancelBtn retain];
    [_cancelBtn addTarget:self action:@selector(onBtnCancel:) forControlEvents:UIControlEventTouchUpInside];
    
    _popUpView = [[PopupView alloc]initWithFrame:CGRectMake(100, 300, 0, 0)];
    _popUpView.ParentView = self.view;
     _login  = [[Login alloc]initWithParentView:self.view];
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
    
    CGRect rect = _resultView.frame;
    if (show) {
        rect.size.height -= kOFFSET_FOR_KEYBOARD;
    }
    else
    {
        rect.size.height += kOFFSET_FOR_KEYBOARD;
    }
    _resultView.frame = rect;
    
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
    
    [_iFlySpeechRecognizer cancel];
    [_iFlySpeechRecognizer setDelegate: nil];
    [_uploader setDelegate:nil];
    _login.delegate =nil;
}

/*
 * @隐藏键盘
 */
-(void)onKeyBoardDown:(id) sender
{
    [_resultView resignFirstResponder];
}

/*
// Implement viewDidLoad to do additional setup after loading the view, typically from a nib.
- (void)viewDidLoad
{
    [super viewDidLoad];
}
*/

-(void) dealloc
{
    [_startBtn release];
    [_stopBtn release];
    [_cancelBtn release];
    
    [_iFlySpeechRecognizer setDelegate:nil];
    [_iFlySpeechRecognizer release];
    [_popUpView release];
    [_params release];
    [_uploadBtn release];
    [_result release];
    [super dealloc];
}

-(void)viewDidLoad
{
    [super viewDidLoad];
    if(![Login isLogin])
    {
        [_login Login];
    }
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
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}

-(void) showPopup
{
    [_popUpView setText: @"正在上传..."];
    [self.view addSubview:_popUpView];
}

#pragma mark - IFlyDataUploaderDelegate
- (void) onEnd:(IFlyDataUploader*) uploader grammerID:(NSString *)grammerID error:(IFlySpeechError *)error
{    
    NSLog(@"%d",[error errorCode]);
    
    if (![error errorCode]) {
        [_popUpView setText: @"上传成功"];
        [self.view addSubview:_popUpView];
        _isUploaded = YES;
    }
    else {
        [_popUpView setText: @"上传失败"];
        [self.view addSubview:_popUpView];
        _isUploaded = NO;
        
    }
    [self setGrammerId:grammerID];
    _uploadBtn.enabled = YES;
}

@end
