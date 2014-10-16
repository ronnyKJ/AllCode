//
//  AppDelegate.h
//  MSCDemo_UI
//
//  Created by iflytek on 13-10-17.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "RootViewController.h"

@interface AppDelegate : UIResponder <UIApplicationDelegate>
{
    NSMutableDictionary         *_initDictionary;
    NSMutableDictionary         *_isrSessionDictionary;
}

@property (retain,nonatomic,readwrite) NSMutableDictionary* initDictionary;
@property (retain,nonatomic,readwrite) NSMutableDictionary* isrSessionDictionary;

@property (strong, nonatomic) UIWindow *window;

@end
