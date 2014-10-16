//
//  Login.h
//  MSCDemo
//
//  Created by hchuang on 13-7-31.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <iflyMSC/IFlySpeechUser.h>

@interface Login : NSObject<IFlySpeechUserDelegate>
+(BOOL) isLogin;
-(void) Login;
-(id) initWithParentView:(UIView*) parentView;
@property(nonatomic,assign) id<IFlySpeechUserDelegate> delegate;
@end
