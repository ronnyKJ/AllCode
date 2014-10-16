//
//  ISRViewController.m
//  MSCDemo
//
//  Created by iflytek on 13-6-6.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import "ISRViewController.h"
#import <QuartzCore/QuartzCore.h>
#import "iflyMSC/IFlyContact.h"
#import "iflyMSC/IFlyDataUploader.h"
#import "Definition.h"
#import "iflyMSC/IFlyUserWords.h"
#import "RecognizerFactory.h"
#import "UIPlaceHolderTextView.h"
@implementation ISRViewController

static NSString * _grammerId;

-(void) setGrammerId:(NSString*) id
{
    [_grammerId release];
    _grammerId = [id retain];
    [_iFlySpeechRecognizer setParameter:@"grammarID" value:_grammerId];
}

- (id) init
{
    self = [super init];
   // [_iFlySpeechRecognizer startListening];
    if (!self) {
        return nil;
    }
    // 创建识别对象
    _iFlySpeechRecognizer = [[RecognizerFactory CreateRecognizer:self Domain:@"sms"] retain];
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
    int top = Margin*2;
    //转写
    self.title = @"语音转文本";
    UIPlaceHolderTextView *resultView = [[UIPlaceHolderTextView alloc] initWithFrame:
                              CGRectMake(Margin*2, top, self.view.frame.size.width-Margin*4, 160)];
    resultView.layer.cornerRadius = 8;
    resultView.layer.borderWidth = 1;
    [self.view addSubview:resultView];
    resultView.font = [UIFont systemFontOfSize:17.0f];
    resultView.placeholder = @"识别结果";
    //键盘
    UIBarButtonItem *spaceBtnItem= [[ UIBarButtonItem alloc] initWithBarButtonSystemItem:UIBarButtonSystemItemFlexibleSpace target:nil action:nil];
    UIBarButtonItem * hideBtnItem = [[UIBarButtonItem alloc] initWithTitle:@"隐藏" style:UIBarStyleBlackOpaque target:self action:@selector(onKeyBoardDown:)];
    UIToolbar * toolbar = [[ UIToolbar alloc]initWithFrame:CGRectMake(0, 0, self.view.frame.size.width, 44)];
    toolbar.barStyle = UIBarStyleBlackTranslucent;
    NSArray * array = [NSArray arrayWithObjects:spaceBtnItem,hideBtnItem, nil];
    [toolbar setItems:array];
    //resultView.inputAccessoryView = toolbar;
    [resultView setEditable:NO];
    [toolbar release];
    [hideBtnItem release];
    [spaceBtnItem release];
    _resultView = resultView;
  
    
    UIButton *startBtn = [[UIButton buttonWithType:UIButtonTypeRoundedRect] retain];
    [startBtn setTitle:@"开始识别" forState:UIControlStateNormal];
    startBtn.frame = CGRectMake(Padding, resultView.frame.origin.y + resultView.frame.size.height + Margin, (self.view.frame.size.width-Padding*4)/3, ButtonHeight);
    [self.view addSubview:startBtn];
    [startBtn addTarget:self action:@selector(onBtnStart:) forControlEvents:UIControlEventTouchUpInside];
    _startBtn = startBtn;
    
    UIButton *stopBtn = [[UIButton buttonWithType:UIButtonTypeRoundedRect]retain];
    [stopBtn setTitle:@"停止" forState:UIControlStateNormal];
    stopBtn.frame = CGRectMake(startBtn.frame.origin.x+ Padding + startBtn.frame.size.width, startBtn.frame.origin.y, (self.view.frame.size.width-Padding*4)/3, ButtonHeight);
    [self.view addSubview:stopBtn];
    _stopBtn = stopBtn;
    [stopBtn addTarget:self action:@selector(onBtnStop:) forControlEvents:UIControlEventTouchUpInside];
    
    UIButton *cancelBtn = [[UIButton buttonWithType:UIButtonTypeRoundedRect] retain];
    [cancelBtn setTitle:@"取消" forState:UIControlStateNormal];
    cancelBtn.frame = CGRectMake(stopBtn.frame.origin.x+ Padding + stopBtn.frame.size.width, stopBtn.frame.origin.y, stopBtn.frame.size.width, stopBtn.frame.size.height);
    [self.view addSubview:cancelBtn];
    [cancelBtn addTarget:self action:@selector(onBtnCancel:) forControlEvents:UIControlEventTouchUpInside];
    _cancelBtn = cancelBtn;
    

//    [self translate:[self urlEncodeValue:@"我们去吃饭吧"]];
    CGRect rect = CGRectMake(0, 300, 280, 100);
    translation = [[UILabel alloc] initWithFrame:rect];
    // 设置UILabel文字
    translation.text = @"翻译结果";
    [self.view addSubview:translation];
    
    _popUpView = [[PopupView alloc]initWithFrame:CGRectMake(100, 300, 0, 0)];
    _popUpView.ParentView = self.view;
}


- (NSString *) translate:text{    
    // 组合一个搜索字符串
    NSString *urlStr = [NSString stringWithFormat:@"http://fanyi.youdao.com/openapi.do?keyfrom=ronaldinhokj&key=1478216563&type=data&doctype=jsonp&callback=callback&version=1.1&q=%@", text];
    // 字符串转化为URL
    NSURL *url = [NSURL URLWithString:urlStr];
    
    // url转化为一个请求
    NSURLRequest *request = [NSURLRequest requestWithURL:url];
    // 状态请求
    NSURLResponse *response;
    // 链接一个请求
    NSData *resultData = [NSURLConnection sendSynchronousRequest:request returningResponse:&response error:nil];
    // 返回数据转为字符串
    NSString *dataString = [[NSString alloc] initWithData:resultData encoding:NSUTF8StringEncoding];
    
    NSRange range = NSMakeRange(9, dataString.length-11);
    NSString *jsonStr = [dataString substringWithRange:range];
    NSLog(@"%@", jsonStr);
    
    NSError *error;
    
    
    NSDictionary *json = [NSJSONSerialization JSONObjectWithData:[jsonStr dataUsingEncoding: NSUTF8StringEncoding] options:NSJSONReadingMutableLeaves error:&error];
    NSString *translationText = [json objectForKey:@"translation"][0];
    translation.text = translationText;
    return @"";
}

- (NSString *)urlEncodeValue:(NSString *)str
{
    NSString *result = (NSString *) CFURLCreateStringByAddingPercentEscapes(kCFAllocatorDefault, (CFStringRef)str, NULL, NULL, kCFStringEncodingUTF8);
    return [result autorelease];
}

/*
 * @隐藏键盘
 */
-(void)onKeyBoardDown:(id) sender
{
    [_resultView resignFirstResponder];
}



// Implement viewDidLoad to do additional setup after loading the view, typically from a nib.
- (void)viewDidLoad
{
    [super viewDidLoad];
}


- (void)viewDidUnload
{
    [super viewDidUnload];
    self.view = nil;
    
}

-(void)viewWillDisappear:(BOOL)animated
{
    [_iFlySpeechRecognizer cancel];
    [_iFlySpeechRecognizer setDelegate: nil];
    [_uploader setDelegate:nil];
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    // Return YES for supported orientations
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}

-(void) dealloc
{
    [_popUpView release];
    [_resultView release];
    [_iFlySpeechRecognizer setDelegate:nil];
    [_iFlySpeechRecognizer release];
    [_domain release];
    
    [_startBtn release];
    [_cancelBtn release];
    [_uploader release];
    [_result release];
    [super dealloc];
}

#pragma mark - Button Handler
/*
 * @开始录音
 */
- (void) onBtnStart:(id) sender
{
    [_resultView resignFirstResponder];
    bool ret = [_iFlySpeechRecognizer startListening];
    if (ret) {
        _isCancel = NO;
    }
    else
    {
        [_popUpView setText: @"启动识别服务失败，请稍后重试"];//可能是上次请求未结束
        [self.view addSubview:_popUpView];
    }
    
}
     
-(void) startListening
{
    [_iFlySpeechRecognizer startListening];
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
    _isCancel = YES;
    [_iFlySpeechRecognizer cancel];
    [_popUpView removeFromSuperview];
    [_resultView resignFirstResponder];
}

-(void) onUploadContact:(id)sender
{
    [_iFlySpeechRecognizer stopListening];
    // 获取联系人
    IFlyContact *iFlyContact = [[IFlyContact alloc] init];
    NSString *contact = [iFlyContact contact];
    _resultView.text = contact;
    #define CONTACT @"subject=uup,dtt=contact"
    [self showPopup];
    [_uploader uploadData:@"contact" params:CONTACT data: _resultView.text];
    [iFlyContact release];

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
    if (_isCancel) {
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
    if (_isCancel) {
        text = @"识别取消";
    }
    else if (error.errorCode ==0 ) {
        if (_result.length==0) {
            text = @"无识别结果";
        }
        else
        {
            text = @"识别成功";
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
        [result appendFormat:@"%@",key];
    }

    
    _result = [result retain];
    _resultView.text = [NSString stringWithFormat:@"%@%@", _resultView.text, result];
    
    [self translate:[self urlEncodeValue:result]];
    [result release];
}

/**
 * @fn      onCancel
 * @brief   取消识别回调
 * 当调用了`cancel`函数之后，会回调此函数，在调用了cancel函数和回调onError之前会有一个短暂时间，您可以在此函数中实现对这段时间的界面显示。
 * @param   
 * @see
 */
- (void) onCancel
{
    NSLog(@"识别取消");
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
    }
    else {
        [_popUpView setText: @"上传失败"];
        [self.view addSubview:_popUpView];
        
    }
    [self setGrammerId:grammerID];
}


@end
