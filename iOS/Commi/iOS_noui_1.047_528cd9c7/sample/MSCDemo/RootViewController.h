//
//  RootViewController.h
//  MSCDemo
//
//  Created by iflytek on 13-6-6.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "iflyMSC/IFlySpeechUser.h"
#import "Definition.h"
#import "PopupView.h"

@interface RootViewController : UIViewController<UITableViewDelegate,UITableViewDataSource>
{ 
    NSArray         *_functions;
    UITextView      *_thumbView;
    PopupView       * _popUpView;
}
@end
