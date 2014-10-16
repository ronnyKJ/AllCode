//
//  ContectViewController.h
//  MSC
//
//  Created by iflytek on 13-4-11.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "ISRTextView.h"

#import "iflyMSC/IFlyDataUploader.h"
#import "iflyMSC/IFlyContact.h"

#define CONTACT @"subject=uup,dtt=contact"

@interface ContectViewController : UIViewController<IFlyDataUploaderDelegate,IFlySpeechUserDelegate>
{
    UIAlertView         *_alertView;
    ISRTextView         *_isrTextView;
    
    UIButton            *_loginButton;
    UIButton            *_uploadButton;
    
    IFlyDataUploader    *_uploader;

}
@end
