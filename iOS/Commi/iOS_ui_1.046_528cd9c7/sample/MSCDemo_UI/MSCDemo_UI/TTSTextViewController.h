//
//  TTSTextViewController.h
//  MSC
//
//  Created by iflytek on 13-4-11.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//


#import "iflyMSC/IFlySynthesizerViewDelegate.h"
#import "iflyMSC/IFlySynthesizerView.h"
#import "UISynthesizerSetupController.h"


#define SYN_TEXT_SHOW @"科大讯飞作为中国最大的智能语音技术提供商，在智能语音技术领域有着长期的研究积累、\
并在中文语音合成、语音识别、口语评测等多项技术上拥有国际领先的成果。科大讯飞是我国唯一以语音技术为产业化方\
向的“国家863计划成果产业化基地”、“国家规划布局内重点软件企业”、“国家火炬计划重点高新技术企业”、\
“国家高技术产业化示范工程”，并被信息产业部确定为中文语音交互技术标准工作组组长单位，\
牵头制定中文语音技术标准。2003年，科大讯飞获迄今中国语音产业唯一的“国家科技进步奖（二等）”，\
2005年获中国信息产业自主创新最高荣誉“信息产业重大技术发明奖”。2006年至2009年，\
连续四届英文语音合成国际大赛（Blizzard Challenge ）荣获第一名。2008年获国际说话人识别评测大赛\
（美国国家标准技术研究院—NIST 2008）桂冠，2009年获得国际语种识别评测大赛（NIST 2009）高难度混淆方言\
测试指标冠军、通用测试指标亚军"

#define APPID       @"528cd9c7"

@interface TTSTextViewController : UIViewController<IFlySynthesizerViewDelegate>
{
    UITextView              *_textView;
    IFlySynthesizerView     *_iFlySynthesizerView;
    
    UIButton                *_beginButton;
    UISynthesizerSetupController *_synthesizerSetupController;
}

@end
