//
//  ISRTextView.m
//  MSC
//
//  Created by iflytek on 13-4-18.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import "ISRTextView.h"
#import <QuartzCore/QuartzCore.h>

@implementation ISRTextView

@synthesize ent = _ent;

- (id)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    if (self) {
        self.backgroundColor = [UIColor whiteColor];
        _textView = [[UITextView alloc] initWithFrame:CGRectMake(10, 10, 300, 200)];
        _textView.font = [UIFont boldSystemFontOfSize:17];
        
        _textView.layer.cornerRadius = 4.0f;
        _textView.layer.borderWidth = 1.0f;
        _textView.layer.borderColor = [[UIColor colorWithRed:0 green:0 blue:0 alpha:0.5] CGColor];
        [self addSubview:_textView];
        UIButton *beginButton = [UIButton buttonWithType:UIButtonTypeRoundedRect];
        beginButton.frame = CGRectMake(15, 250, 280, 50);
        [beginButton setTitle:@"开始识别" forState:UIControlStateNormal];
        [beginButton addTarget:self action:@selector(onBegin:) forControlEvents:UIControlEventTouchUpInside];
        [self addSubview:beginButton];
        
        NSString *initString = [[NSString alloc] initWithFormat:@"appid=%@",APPID ];
        _iFlyRecognizerView = [[IFlyRecognizerView alloc] initWithOrigin:CGPointMake(15, 60) initParam:initString];
        _iFlyRecognizerView.delegate = self;
        [initString release];
//        [self addSubview: _iFlyRecognizerView];
        
        UIToolbar * topView = [[UIToolbar alloc]initWithFrame:CGRectMake(0, 0, 320, 30)];
        [topView setBarStyle:UIBarStyleDefault];
        
//        UIBarButtonItem * helloButton = [[UIBarButtonItem alloc]initWithTitle:@"Hello" style:UIBarButtonItemStyleBordered target:self action:nil];
        
        UIBarButtonItem * btnSpace = [[UIBarButtonItem alloc]initWithBarButtonSystemItem:UIBarButtonSystemItemFlexibleSpace target:self action:nil];
        
        UIBarButtonItem * doneButton = [[UIBarButtonItem alloc]initWithTitle:@"Done" style:UIBarButtonItemStyleDone target:self action:@selector(dismissKeyBoard)];
        
        
        NSArray * buttonsArray = [NSArray arrayWithObjects:/*helloButton,*/btnSpace,doneButton,nil];
        [doneButton release];
        [btnSpace release];
        [topView setItems:buttonsArray];
        [_textView setInputAccessoryView:topView];
        [topView release];
        // Initialization code
    }
    return self;
}


- (void) setGrammar:(NSString *)grammar
{
    [_grammarID release];
    _grammarID = [grammar retain];
}
- (void) setText:(NSString *) text
{
    _textView.text = text;
}

- (NSString*) getText
{
    return _textView.text;
}

- (void) onBegin:(id) sender
{
    _textView.text = nil;
    [_iFlyRecognizerView setParameter:@"grammarID" value:_grammarID];

    // 参数设置
    [_iFlyRecognizerView setParameter:@"domain" value:_ent];
    [_iFlyRecognizerView setParameter:@"sample_rate" value:@"16000"];
    [_iFlyRecognizerView setParameter:@"vad_eos" value:@"1800"];
    [_iFlyRecognizerView setParameter:@"vad_bos" value:@"6000"];
    [_iFlyRecognizerView start];
}

- (void) onResult:(IFlyRecognizerView *)iFlyRecognizerView theResult:(NSArray *)resultArray
{
    NSMutableString *result = [[NSMutableString alloc] init];
    NSDictionary *dic = [resultArray objectAtIndex:0];
    for (NSString *key in dic) {
        [result appendFormat:@"%@(置信度:%@)\n",key,[dic objectForKey:key]];
    }
    //    NSLog(@"result:%@",results);
    _textView.text = [NSString stringWithFormat:@"%@%@",_textView.text,result];
    
    [result release];
    
}

- (void)onEnd:(IFlyRecognizerView *)iFlyRecognizerView theError:(IFlySpeechError *) error
{
    NSLog(@"recognizer end");
}
/*
// Only override drawRect: if you perform custom drawing.
// An empty implementation adversely affects performance during animation.
- (void)drawRect:(CGRect)rect
{
    // Drawing code
}
*/
-(void) dismissKeyBoard
{
    [_textView resignFirstResponder];
}
@end
