//
//  ASRViewController.h
//  MSC

//  descripiton:命令词识别示例，命令词识别适用于从一组词语中识别结果，如果您说的词语
//  不再这组词中将不会获取到结果。在进行命令词识别之前，也需要将命令词上传到服务器端,
//  生成一个grammarID,每次识别都需要将这个grammarID带上，命令词在服务器端永久保存的，
//  不要对同组词反复上传

//  Created by iflytek on 13-4-17.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "ISRTextView.h"

#import "iflyMSC/IFlyDataUploader.h"
#import "iflyMSC/IFlySpeechUser.h"

#define ASRPARAMS       @"subject=asr,data_type=keylist"
#define ASRWORD         @"阿里山龙胆,浦发银行,邯郸钢铁,齐鲁石化,东北高速,武钢股份,东风汽车,中国国贸,首创股份,上海机场"
#define ASRNAME         @"asrName"

@interface ASRViewController : UIViewController<IFlyDataUploaderDelegate,IFlySpeechUserDelegate>
{
    UIAlertView         *_alertView;
    ISRTextView         *_isrTextView;
    
    UIButton            *_loginButton;
    UIButton            *_uploadButton;
    IFlyDataUploader    *_uploader;
}
@end
