//
//  Definition.h
//  MSCDemo
//
//  Created by iflytek on 13-6-6.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import <Foundation/Foundation.h>
#define Margin  5
#define Padding 10
#define iOS7TopMargin 64 //导航栏44，状态栏20
#define IOS7_OR_LATER   ( [[[UIDevice currentDevice] systemVersion] compare:@"7.0"] != NSOrderedAscending )
#define ButtonHeight 44
#define NavigationBarHeight 44
#define APPID @"528cd9c7"
#define URL             @""                 // url
#define TIMEOUT         @"20000"            // timeout      连接超时的时间，以ms为单位
#define PWD             @""                 // password     密码，在开发者论坛中注册的用户名
#define USR             @""                 // user         用户名，在开发者论坛中注册的用户名
#define BEST_URL        @"1"                   // best_search_url 最优搜索路径


#define SEARCH_AREA     @"安徽省合肥市"
#define ASR_PTT         @"1"
#define VAD_BOS         @"5000"
#define VAD_EOS         @"1800"
#define PLAIN_RESULT    @"1"
#define ASR_SCH         @"1"
@interface Definition : NSObject

@end
