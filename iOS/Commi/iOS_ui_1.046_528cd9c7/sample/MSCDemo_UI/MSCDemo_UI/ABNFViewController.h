//
//  ABNFViewController.h
//  MSC

//  descripiton: abnf语法使用示例，在使用abnf语法之前需要了解abnf语法的语法，在进行语法识别之前，
//  需要将abnf语法上传到服务器端，从服务器端获取一个grammarID,每次识别都需要带上这个grammarID,
//  abnf语法文件上传之后在服务器端是永久保存的，不需要每次都上传

//  Created by iflytek on 13-4-9.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import "ISRTextView.h"

#import "iflyMSC/IFlyDataUploader.h"
#import "iflyMSC/IFlySpeechUser.h"

/*上传abnf语法时，需要上传的参数*/
#define ABNF        @"subject=asr,dtt=abnf"
#define ABNFDATA    @"#ABNF 1.0 UTF-8;\n            \
                    language zh-CN;\n               \
                    mode voice;\n                   \
                    root $main;\n                   \
                    $main = $place1 去 $place2;\n    \
                    $place1 = 北京 | 武汉 | 南京 | 天津 | 天京 |东京;\n \
                    $place2 = 上海 | 合肥;\n\
"

#define ABNFNAME        @"abnf" //名称可以自定义

@interface ABNFViewController : UIViewController<IFlyDataUploaderDelegate,IFlySpeechUserDelegate>
{
    UIAlertView         *_alertView;
    ISRTextView         *_isrTextView;
    
    UIButton            *_loginButton;
    UIButton            *_uploadButton;
    IFlyDataUploader    *_uploader;
}
@end
