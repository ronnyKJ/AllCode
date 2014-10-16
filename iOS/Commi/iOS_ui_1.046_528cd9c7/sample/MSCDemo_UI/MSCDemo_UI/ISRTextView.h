//
//  ISRTextView.h
//  MSC
//
//  Created by iflytek on 13-4-18.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "iflyMSC/IFlyRecognizerViewDelegate.h"
#import "iflyMSC/IFlyRecognizerView.h"

#define APPID       @"528cd9c7"

@interface ISRTextView : UIView<IFlyRecognizerViewDelegate>
{
    UITextView                      *_textView;
    IFlyRecognizerView              *_iFlyRecognizerView;
    UIButton                        *_beginButton;
    NSString                        *_ent;
    NSString                        *_grammarID;
}

@property(copy) NSString *ent;

- (void) setText:(NSString *) text;
- (NSString*) getText;

- (void) setGrammar:(NSString *)grammar;
@end
