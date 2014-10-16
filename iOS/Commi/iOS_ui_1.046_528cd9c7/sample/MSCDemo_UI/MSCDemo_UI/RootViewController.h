//
//  MainViewController.h
//  MSC
//
//  Created by iflytek on 13-4-7.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "CustomViewController.h"
#import "ISRTextViewController.h"
#import "TTSTextViewController.h"

@interface RootViewController : UITableViewController
{
    NSDictionary            *_dictionary;
    TTSTextViewController   *_ttsTextViewController;        //语音合成
    ISRTextViewController   *_isrTextViewController;        //普通文本转写
    CustomViewController    *_smsViewController;
    CustomViewController    *_asrViewController;
}
@end
