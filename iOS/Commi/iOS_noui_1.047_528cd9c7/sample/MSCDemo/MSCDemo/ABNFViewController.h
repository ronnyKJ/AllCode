//
//  ABNFViewController.h
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
@interface ABNFViewController : UIViewController<IFlySpeechRecognizerDelegate,IFlyDataUploaderDelegate>
{
    IFlySpeechRecognizer             * _iFlySpeechRecognizer;
    PopupView                        * _popUpView;
    NSString                         * _params;
    UITextView                       * _resultView;
    NSMutableString                  * _result;// 所有结果
    NSMutableString                  * _curResult;//当前session的结果
    
    UIButton                         * _stopBtn;
    UIButton                         * _cancelBtn;
    UIButton                         * _startBtn;
    bool                               _isCancled;
    UIButton                         * _uploadBtn;
    BOOL                               _isUploaded; 
    IFlyDataUploader                 * _uploader;
    Login                            * _login ;
}
-(void)setViewSize:(BOOL)movedUp Notification:(NSNotification*) notification;
@end
