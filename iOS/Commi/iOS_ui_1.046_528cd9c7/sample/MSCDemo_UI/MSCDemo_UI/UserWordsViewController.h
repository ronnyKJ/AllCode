//
//  UserWordsViewController.h
//  MSC
//
//  Created by iflytek on 13-4-17.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import <UIKit/UIKit.h>

#import "ISRTextView.h"

#import "iflyMSC/IFlyDataUploader.h"
#import "iflyMSC/IFlySpeechUser.h"

#define USERWORDS   @"{\"userword\":[{\"name\":\"iflytek\",\"words\":[\"科大讯飞\",\"云平台\",\"用户词条1\",\"开始上传词条\"]}]}"

#define PARAMS @"sub=iat,dtt=userword"
#define NAME @"userwords"

@interface UserWordsViewController : UIViewController <IFlyDataUploaderDelegate,IFlySpeechUserDelegate>
{
    UIAlertView         *_alertView;
    ISRTextView         *_isrTextView;
    
    UIButton            *_loginButton;
    UIButton            *_uploadButton;
    
    IFlyDataUploader    *_uploader;

}
@end
