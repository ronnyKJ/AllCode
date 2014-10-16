//
//  TTSViewController.h
//  MSCDemo
//
//  Created by iflytek on 13-6-6.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "iflyMSC/IFlySpeechSynthesizerDelegate.h"
#import "iflyMSC/IFlySpeechRecognizer.h"
#import "iflyMSC/IFlySpeechSynthesizer.h"
#import "Definition.h"
#import "PopupView.h"
#import "AlertView.h"

@interface TTSViewController : UIViewController<IFlySpeechSynthesizerDelegate>
{   IFlySpeechSynthesizer       * _iFlySpeechSynthesizer;
    UITextView                  * _toBeSynthersedTextView;
    UIButton                    * _startBtn;
    UIButton                    * _pauseBtn;
    UIButton                    * _resumeBtn;
    UIButton                    * _cancelBtn;
    PopupView                   * _popUpView;
    int                          _textViewHeight;
    bool                          _isSpeakStarted;
    UIAlertView                 * _baseAlert;
    bool                          _isViewDidDisappear;
    bool                          _hasError;
    AlertView                   * _bufferAlertView;
    AlertView                   * _cancelAlertView;
    bool                          _isCancel;
}
-(void)setViewSize:(BOOL)movedUp Notification:(NSNotification*) notification;
@end
