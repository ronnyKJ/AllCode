//
//  ASRViewController.m
//  MSCDemo
//
//  Created by iflytek on 13-6-6.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import "ASRViewController.h"
#import <QuartzCore/QuartzCore.h>
#import "Definition.h"
#import "RecognizerFactory.h"

#define kOFFSET_FOR_KEYBOARD 160.0
@implementation ASRViewController

static NSString * _grammerId;

+(NSString*)grammerId
{
    return _grammerId;
}

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
    // 创建识别对象
    _iFlySpeechRecognizer = [[RecognizerFactory CreateRecognizer:self Domain:@"asr"] retain];
    _result = [[NSMutableString alloc]init];
    _isCanceled = NO;
    //uploader must create here for thread safty. Because all upload tasks must be put into the same NSoperationQueue.  
    _uploader = [[IFlyDataUploader alloc] initWithDelegate:nil pwd:nil params:nil delegate:self];
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
    self.view = mainView;
    [mainView release];
    self.title = @"命令词识别";
    self.view.backgroundColor = [UIColor whiteColor];
    int height;
    height = self.view.frame.size.height - ButtonHeight*2 - Margin*8-NavigationBarHeight;
    UITextView *resultView = [[UITextView alloc] initWithFrame:
                              CGRectMake(Margin*2, Margin*2, self.view.frame.size.width-Margin*4, height)];
    resultView.layer.cornerRadius = 8;
    resultView.layer.borderWidth = 1;
    resultView.text = @"\t开始识别前请先点击“上传”按钮上传命令词。\n\t开启识别对话框后，您可以说：\n\t阿里山龙胆、浦发银行、邯郸钢铁、齐鲁石化、东北高速、武钢股份、东风汽车、中国国贸、首创股份、上海机场、钢联股份、民生银行、上港集箱、宝钢股份、福建高速、歌华有线、哈飞股份、宁波联合、浙江广厦、江西纸业、黄山旅游、万东医疗、中技贸易...";
    
    resultView.font = [UIFont systemFontOfSize:17.0f];
    
    resultView.pagingEnabled = YES;
    UIEdgeInsets aUIEdge = [resultView contentInset]; 
    aUIEdge.left = 10;
    aUIEdge.right = 10;
    aUIEdge.top = 10;
    aUIEdge.bottom = 10;
    resultView.contentInset = aUIEdge;
    [resultView setEditable:NO];
    [self.view addSubview:resultView];
    
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
    _resultView = resultView;
    
    //命令词上传
    UIButton *uploadBtn = [UIButton buttonWithType:UIButtonTypeRoundedRect];
    [uploadBtn setTitle:@"命令词上传" forState:UIControlStateNormal];
    uploadBtn.frame = CGRectMake(Padding, resultView.frame.origin.y + resultView.frame.size.height + Margin*2, (self.view.frame.size.width-Padding*3)/2, ButtonHeight);
    [self.view addSubview:uploadBtn];
    [uploadBtn addTarget:self action:@selector(onBtnUpload:) forControlEvents:UIControlEventTouchUpInside];
    _uploadBtn = [uploadBtn retain];
    
    //开始识别
    UIButton *startBtn = [UIButton buttonWithType:UIButtonTypeRoundedRect];
    [startBtn setTitle:@"开始" forState:UIControlStateNormal];
    startBtn.frame = CGRectMake(uploadBtn.frame.origin.x+ Padding + uploadBtn.frame.size.width, uploadBtn.frame.origin.y, uploadBtn.frame.size.width, uploadBtn.frame.size.height);
    [self.view addSubview:startBtn];
    [startBtn addTarget:self action:@selector(onBtnStart:) forControlEvents:UIControlEventTouchUpInside];
    _startBtn = [startBtn retain];
    
    //停止监听
    UIButton *stopBtn = [UIButton buttonWithType:UIButtonTypeRoundedRect];
    [stopBtn setTitle:@"停止" forState:UIControlStateNormal];
    stopBtn.frame = CGRectMake(Padding, startBtn.frame.origin.y + startBtn.frame.size.height + Margin, (self.view.frame.size.width-Padding*3)/2, ButtonHeight);
    [self.view addSubview:stopBtn];
    [stopBtn addTarget:self action:@selector(onBtnStop:) forControlEvents:UIControlEventTouchUpInside];
    _stopBtn = [stopBtn retain];
    
    //取消
    UIButton *cancelBtn = [UIButton buttonWithType:UIButtonTypeRoundedRect];
    [cancelBtn setTitle:@"取消" forState:UIControlStateNormal];
    cancelBtn.frame = CGRectMake(stopBtn.frame.origin.x+ Padding + stopBtn.frame.size.width, stopBtn.frame.origin.y, stopBtn.frame.size.width, stopBtn.frame.size.height);
    [self.view addSubview:cancelBtn];   
    [cancelBtn addTarget:self action:@selector(onBtnCancel:) forControlEvents:UIControlEventTouchUpInside];
    _cancelBtn = [cancelBtn retain];
    
    _popUpView = [[PopupView alloc]initWithFrame:CGRectMake(100, 300, 0, 0)];
    _popUpView.ParentView = self.view;
    _login  = [[Login alloc]initWithParentView:self.view];
}


// Implement viewDidLoad to do additional setup after loading the view, typically from a nib.
- (void)viewDidLoad
{
    [super viewDidLoad];
    _popUpView.ParentView = self.view;
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

-(void) dealloc
{
    [_startBtn release];
    [_stopBtn release];
    [_cancelBtn release];
    [_popUpView release];
    [_iFlySpeechRecognizer setDelegate:nil];
    [_iFlySpeechRecognizer release];
    [_params release];
    [_result release];
    [_uploadBtn release];
    [_uploader release];
    [_login release];
    [super dealloc];
}

#pragma mark - Change view size keyborad show
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
    _login.delegate = nil;
}

/*
 * @隐藏键盘
 */
-(void)onKeyBoardDown:(id) sender
{
    [_resultView resignFirstResponder];
}

#pragma mark - Button handler
/*
 * @ 开始录音
 */
- (void) onBtnStart:(id)sender
{
    if ([ASRViewController grammerId] == nil) {
        [_popUpView setText:@"   请先上传\
             命令词"];
        [self.view addSubview:_popUpView];
        
        return;
    }
    [_iFlySpeechRecognizer setParameter:@"grammarID" value:_grammerId];
    BOOL ret = [_iFlySpeechRecognizer startListening];
    if (ret) {
        _isCanceled = NO;
    }
    else
    {
        [_popUpView setText: @"启动识别服务失败，请稍后重试"];//可能是上次请求未结束
        [self.view addSubview:_popUpView];
    }
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
    [_iFlySpeechRecognizer cancel];
    [_resultView resignFirstResponder];
    _isCanceled = YES;
    [_popUpView removeFromSuperview];
}

- (void) onBtnUpload:(id)sender
{
    [_iFlySpeechRecognizer stopListening];
    _uploadBtn.enabled = NO;
    
    #define ASRPARAMS       @"subject=asr,data_type=keylist"
    #define ASRWORD         @"阿里山龙胆,浦发银行,邯郸钢铁,齐鲁石化,东北高速,武钢股份,东风汽车,中国国贸,首创股份,上海机场,钢联股份,民生银行,上港集箱,宝钢股份,福建高速,歌华有线,哈飞股份,宁波联合,浙江广厦,江西纸业,黄山旅游,万东医疗,中技贸易"
    #define ASRNAME         @"asrName"
    [self showPopup];
    [_uploader uploadData:ASRNAME params:ASRPARAMS data:ASRWORD];
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
    if (_isCanceled) {
        [_popUpView removeFromSuperview];
        return;
    }
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
    if (_isCanceled) {
         text = @"识别取消";
    }
    else if (error.errorCode ==0 ) {
        if (_result.length==0) {
            text = @"无匹配结果";
        }
        else
        {
            text = @"识别成功";
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
    if (_result != Nil) {
        [_result appendString:result ];
    }
    else
    {
        _result = [result retain] ;
    }
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
