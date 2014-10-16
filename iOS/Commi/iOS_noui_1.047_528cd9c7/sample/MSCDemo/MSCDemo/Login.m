//
//  Login.m
//  MSCDemo
//
//  Created by hchuang on 13-7-31.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import "Login.h"
#import "Definition.h"
#import "PopupView.h"

@implementation Login
{
    PopupView           * _popUpView;
    UIView              * _parentView;
    IFlySpeechUser      * _loginUser;
}

-(id) initWithParentView:(UIView*) parentView
{
    self = [super init];
     if (!self) {
        return nil;
    }
    _popUpView = [[PopupView alloc]initWithFrame:CGRectMake(100, 300, 0, 0)];
    return self;
}

+(BOOL) isLogin
{
    return [IFlySpeechUser isLogin];
}

-(void) Login
{
    if (![IFlySpeechUser isLogin]) {
        [_popUpView setText: @"正在登陆..."];
        [_parentView addSubview:_popUpView];
        
        // 需要先登陆
        _loginUser = [[IFlySpeechUser alloc] initWithDelegate:self];
        
        // user 和 pwd 都传入nil时表示是匿名登陆
        NSString *loginString = [[NSString alloc] initWithFormat:@"appid=%@",APPID];
        [_loginUser login:nil pwd:nil param:loginString];
        [loginString autorelease];
    }
    else {
        [_popUpView setText: @"已登陆"];
        [_parentView addSubview:_popUpView];
    }
}

//IFlySpeechUserDelegate
- (void) onEnd:(IFlySpeechUser *)iFlySpeechUser error:(IFlySpeechError *)error
{
    
    if (![error errorCode]) {
        
    }
    else {
        UIAlertView* alertView = [[UIAlertView alloc] initWithTitle:@"登陆失败" message:[error errorDesc] delegate:self cancelButtonTitle:@"确定" otherButtonTitles:nil, nil];
        [alertView show];
        [alertView release];
        NSLog(@"Login error code: %d",error.errorCode);
    }
}

-(void)setDelegate:(id<IFlySpeechUserDelegate>)delegate
{
    _loginUser.delegate = delegate;
}

-(void)dealloc
{
    _loginUser.delegate = nil;
    [_loginUser release];
    _loginUser = nil;
    [super dealloc];
}
@end
