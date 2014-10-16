//
//  ISRViewController.h
//  MSCDemo
//
//  Created by iflytek on 13-6-6.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "iflyMSC/IFlySpeechRecognizer.h"
#import "iflyMSC/IFlyDataUploader.h"
#import "PopupView.h"
@interface ISRViewController : UIViewController<IFlySpeechRecognizerDelegate,IFlyDataUploaderDelegate>
{
    IFlySpeechRecognizer    * _iFlySpeechRecognizer;
    NSString                * _domain;
    UITextView              * _resultView ;
    PopupView               * _popUpView;
    UIButton                * _stopBtn;
    UIButton                * _cancelBtn;
    UIButton                * _startBtn;
    bool                      _isCancel;
    IFlyDataUploader        * _uploader;
    NSString                * _result;
    UILabel                 * translation;
}
-(void) setGrammerId:(NSString*) id;
@end
