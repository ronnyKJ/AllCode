//
//  ASRViewController.h
//  MSCDemo
//
//  Created by iflytek on 13-6-6.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "iflyMSC/IFlySpeechRecognizer.h"
#import "iflyMSC/IFlyDataUploader.h"
#import "PopupView.h"
#import "Login.h"

@interface ASRViewController : UIViewController<IFlySpeechRecognizerDelegate,IFlyDataUploaderDelegate>
{
    IFlySpeechRecognizer             * _iFlySpeechRecognizer;
    PopupView                        * _popUpView;
    NSString                         * _params;
    UITextView                       * _resultView;
    UIButton                         * _stopBtn;
    UIButton                         * _cancelBtn;
    UIButton                         * _startBtn;
    NSMutableString                  * _result;
    Boolean                            _isUploaded;
    bool                               _isCanceled;
    UIButton                         * _uploadBtn;
    IFlyDataUploader                 * _uploader;
    Login                            * _login ;
}

-(void)setViewSize:(BOOL)movedUp Notification:(NSNotification*) notification;
@end
