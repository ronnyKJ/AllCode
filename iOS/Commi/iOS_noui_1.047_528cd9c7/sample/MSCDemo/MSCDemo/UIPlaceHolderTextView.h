//
//  UIPlaceHolderTextView.h
//  MSCDemo
//
//  Created by iflytek on 13-6-17.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface UIPlaceHolderTextView : UITextView
@property (nonatomic, retain) NSString *placeholder;
@property (nonatomic, retain) UIColor *placeholderColor;
@property (nonatomic, retain) UILabel *placeHolderLabel;
-(void)textChanged:(NSNotification*)notification;
@end
