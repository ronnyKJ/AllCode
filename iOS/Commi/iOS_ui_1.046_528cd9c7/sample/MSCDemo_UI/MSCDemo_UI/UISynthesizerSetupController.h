//
//  UISynthesizerSetupController.h
//  MSC20Demo

//  description:合成设置类

//  Created by iflytek on 12-9-12.
//  Copyright 2012 IFLYTEK. All rights reserved.
//

#import <UIKit/UIKit.h>


// 显示合成界面
#define H_SYNTHESIZER_UI_LABEL_FRAME		CGRectMake(20, 20, 130, 20)
#define H_SYNTHESIZER_UI_SWITCH_FRAME		CGRectMake(170, 25, 100, 20)

// the coordinates for backgound voice label
// 背景音
#define H_BG_VOICE_LABEL_FRAME				CGRectMake(20, 65, 130, 40)
#define H_BG_VOICE_SWITCH_FRAME				CGRectMake(170, 65, 100, 40)

// the coordinates for person voice label
// 发音人
#define H_PERSON_VOICE_LABEL_FRAME			CGRectMake(20, 110, 130, 40)
#define H_PERSON_VOICE_SEG_FRAME			CGRectMake(170, 115, 90, 30)

// the coordinates for speed voice label
// 调整语速
#define H_SPEED_VOICE_LABEL_FRAME			CGRectMake(20, 160, 100, 40)
#define H_SPEED_VOICE_SLI_FRAME				CGRectMake(140, 165, 150, 15) 

// the coordinates for volume voice label
// 调整音量
#define H_VOLUME_VOICE_LABEL_FRAME			CGRectMake(20, 200, 100, 40)
#define H_VOLUME_VOICE_SLI_FRAME			CGRectMake(140, 205, 150, 15) 


#define H_UI_LABEL_FRAME		CGRectMake(20, 10, 150, 20)
#define H_UI_CONTEXT_FRAME		CGRectMake(170, 10, 100, 30)
#define H_UI_TEXT_FRAME         CGRectMake(170, 10, 100, 20)
#define H_UI_PICKER_FRAME       CGRectMake(60, 10, 200, 162)

#define SYNSETUP_TITLE @"合成设置"

#import "iflyMSC/IFlySynthesizerView.h"

@interface UISynthesizerSetupController : UITableViewController <UIPickerViewDelegate,UIPickerViewDataSource>
{
    
    IFlySynthesizerView         *_iFlySynthesizerView;
	UILabel						*_bgVoiceLabel;
	UISwitch					*_bgVoiceSwitch;
    
	UILabel						*_personVoiceLabel;
	UILabel                     *_personVoiceText;
    UIPickerView				*_personVoicePickerView;
	// 3
	UILabel						*_speedVoiceLabel;
	UISlider					*_speedVoiceSlider;
	
	// 4
	UILabel						*_volumeVoiceLabel;
	UISlider					*_volumeVoiceSlider;
    
    NSArray						*_pickerViewArray;
    NSInteger					_selectRow;
    NSArray                     *_VoiceNamearray;
}

- (id)initWithSynthesizer:(IFlySynthesizerView *)iFlySynthesizerView;

@end
