//
//  UISynthesizerSetupController.m
//  MSC20Demo

//  description: you can setup the synthesizercontroller

//  Created by msp on 12-9-12.
//  Copyright 2012 IFLYTEK. All rights reserved.
//

// 本接口主要实现了对语音合成控件的设置，
#import "UISynthesizerSetupController.h"

@interface UISynthesizerSetupController(Private)

- (void)bgSwitchValueChanged;

- (void)personVoiceSegValueChanged;

- (void)speedValueChanged;

- (void)volumeValueChanged;

@end

@implementation UISynthesizerSetupController

- (id)initWithSynthesizer:(IFlySynthesizerView *)iFlySynthesizerView
{
	if (self = [super initWithStyle:UITableViewStyleGrouped])
	{
		self.title = SYNSETUP_TITLE;
		_iFlySynthesizerView = [iFlySynthesizerView retain];
	}
	return self;
}

- (void)dealloc
{
    [_iFlySynthesizerView release];
    [_volumeVoiceLabel release];
    [_VoiceNamearray release];
    [_pickerViewArray release];
    [_bgVoiceLabel release];
    [_bgVoiceSwitch release];
    [_personVoiceLabel release];
    [_personVoiceText  release];
    [_speedVoiceLabel release];

    [_personVoicePickerView release];
    [_speedVoiceSlider release];
    
    [_volumeVoiceSlider release];
    
    [super dealloc];
}

#pragma mark
#pragma mark 内部调用

//  set whether to show UI
//  设置是否显示UI
- (void)synthesizerUIChanged
{
}


// 设置合成过程中是否有背景音乐
- (void)bgSwitchValueChanged
{
	if(_bgVoiceSwitch.on == YES)
	{
		[_iFlySynthesizerView setParameter:@"params" value:[NSString stringWithFormat:@"bgs=1"]];
	}
	else
	{
		[_iFlySynthesizerView setParameter:@"params" value:[NSString stringWithFormat:@"bgs=0"]];
	}
	
}


// set the voice speed
// 设置语速
- (void)speedValueChanged
{
    [_iFlySynthesizerView setParameter:@"speed" value:[NSString stringWithFormat:@"%f",_speedVoiceSlider.value]];
}

// set the volume
// 设置音量
- (void)volumeValueChanged
{
       [_iFlySynthesizerView setParameter:@"volume" value:[NSString stringWithFormat:@"%f",_volumeVoiceSlider.value]];
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    _pickerViewArray = [[NSArray alloc] initWithObjects:@"小燕 (中英文普通话)",@"小雨 中英文(普通话)",@"凯瑟琳 英文(青年女声)",
                        @"亨利 英文(青年男声)",@"玛丽 英文(青年女声)",@"小研 中英文(普通话)",@"小琪 中英文(普通话)",@"小峰 中英文(普通话)",@"小梅 中英文(粤语)",
                        @"小莉 中英文(台湾普通话)",@"小蓉 汉语(四川话)",@"小芸 汉语(东北话)",@"小坤 汉语(河南话)",@"小强 汉语(湖南话)",@"小莹 汉语(陕西话)",
                        @"小新 汉语(普通话)",@"楠楠 汉语(普通话)",@"老孙 汉语(普通话)",nil];

    
    _VoiceNamearray = [[NSArray alloc] initWithObjects:@"xiaoyan",@"xiaoyu",@"Catherine",
                      @"henry",@"vimary",@"vixy",@"vixq",@"vixf",@"vixm",
                      @"vixl",@"vixr",@"vixyun",@"vixk",@"vixqa",@"vixying",
                      @"vixx",@"vinn",@"vils",nil];

    // 配置合成设置界面

    _personVoicePickerView = [[UIPickerView alloc] initWithFrame:CGRectZero];
	_personVoicePickerView.delegate = self;
	_personVoicePickerView.dataSource = self;
	
	_personVoicePickerView.frame = CGRectMake(10, 10, 300, 50);//[self pickerFrameWithSize:pickerSize];
	
	_personVoicePickerView.showsSelectionIndicator = YES;	// note this is default to NO
	
	_personVoicePickerView.hidden = NO;
	
	_selectRow = 0;
	[_personVoicePickerView selectRow:_selectRow inComponent:0 animated:NO];
    
	// 合成背景音 1
	_bgVoiceLabel = [[UILabel alloc] initWithFrame:H_UI_LABEL_FRAME];
	_bgVoiceLabel.text = @"合成背景音:";
	_bgVoiceLabel.backgroundColor = [UIColor clearColor];
	_bgVoiceLabel.font = [UIFont systemFontOfSize:20.0f];
	_bgVoiceLabel.textColor = [UIColor blackColor];
	_bgVoiceLabel.textAlignment = UITextAlignmentLeft;
	//[self.view addSubview:_bgVoiceLabel];
	
	_bgVoiceSwitch = [[UISwitch alloc] initWithFrame:H_UI_CONTEXT_FRAME];
	[_bgVoiceSwitch addTarget:self action:@selector(bgSwitchValueChanged) forControlEvents:UIControlEventValueChanged];
    _bgVoiceSwitch.on = NO;
	//[self.view addSubview:_bgVoiceSwitch];
	
	// 发音人 2
	_personVoiceLabel = [[UILabel alloc] initWithFrame:H_UI_LABEL_FRAME];
	_personVoiceLabel.text = @"选择发音人:";
	_personVoiceLabel.backgroundColor = [UIColor clearColor];
	_personVoiceLabel.font = [UIFont systemFontOfSize:20.0f];
	_personVoiceLabel.textColor = [UIColor blackColor];
	_personVoiceLabel.textAlignment = UITextAlignmentLeft;
	//[self.view addSubview:_personVoiceLabel];
	
	_personVoiceText = [[UILabel alloc] initWithFrame:H_UI_TEXT_FRAME];
	_personVoiceText.backgroundColor = [UIColor clearColor];
    _personVoiceText.font = [UIFont systemFontOfSize:20.0f];
    _personVoiceText.textAlignment = UITextAlignmentLeft;
    _personVoiceText.text = @"小燕";
    //	[_personVoiceSegment addTarget:self action:@selector(personVoiceSegValueChanged) forControlEvents:UIControlEventValueChanged];
    //	_personVoiceSegment.selectedSegmentIndex = 1;
    //	//[self.view addSubview:_personVoiceSegment];
	
	
	
	// 语速 3
	_speedVoiceLabel = [[UILabel alloc] initWithFrame:H_UI_LABEL_FRAME];
	_speedVoiceLabel.text = @"语速:";
	_speedVoiceLabel.backgroundColor = [UIColor clearColor];
	_speedVoiceLabel.font = [UIFont systemFontOfSize:20.0f];
	_speedVoiceLabel.textColor = [UIColor blackColor];
	_speedVoiceLabel.textAlignment = UITextAlignmentLeft;
	//[self.view addSubview:_speedVoiceLabel];
	
	_speedVoiceSlider = [[UISlider alloc] initWithFrame:H_UI_CONTEXT_FRAME];
	_speedVoiceSlider.minimumValue = 1;
	_speedVoiceSlider.maximumValue = 100;
	_speedVoiceSlider.value = 50;
	[_speedVoiceSlider addTarget:self action:@selector(speedValueChanged) forControlEvents:UIControlEventValueChanged];
	
	//[self.view addSubview:_speedVoiceSlider];
	
	// 音量
	_volumeVoiceLabel = [[UILabel alloc] initWithFrame:H_UI_LABEL_FRAME];
	_volumeVoiceLabel.text = @"音量:";
	_volumeVoiceLabel.backgroundColor = [UIColor clearColor];
	_volumeVoiceLabel.font = [UIFont systemFontOfSize:20.0f];
	_volumeVoiceLabel.textColor = [UIColor blackColor];
	_volumeVoiceLabel.textAlignment = UITextAlignmentLeft;
	//[self.view addSubview:_volumeVoiceLabel];
	
	_volumeVoiceSlider = [[UISlider alloc] initWithFrame:H_UI_CONTEXT_FRAME];
	_volumeVoiceSlider.minimumValue = 1;
	_volumeVoiceSlider.maximumValue = 100;
	_volumeVoiceSlider.value = 50;
	[_volumeVoiceSlider addTarget:self action:@selector(volumeValueChanged) forControlEvents:UIControlEventValueChanged];
	
	[self bgSwitchValueChanged];
    //	[self personVoiceSegValueChanged];
	[self speedValueChanged];
	[self volumeValueChanged];
}

#pragma mark -
#pragma mark Table view data source

// Customize the number of sections in the table view.
- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView {
    return 2;
}


// Customize the number of rows in the table view.
- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section {
    if(section == 0)
        return 4;
    else
        return 1;
}
//- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
//{
//	CGFloat height = 0;
//	if (indexPath.section == 0)
//	{
//		height = 40;
//	}
//	else
//	{
//		height = 180;
//	}
//	return height;
//}

// Customize the appearance of table view cells.
- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath {
    
    static NSString *CellIdentifier = @"Cell";
    
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:CellIdentifier];
    if (cell == nil)
	{
        cell = [[[UITableViewCell alloc] initWithStyle:UITableViewCellStyleSubtitle reuseIdentifier:nil] autorelease];
    }
	
    cell.selectionStyle = UITableViewCellSelectionStyleBlue;
	
	// Configure the cell.
    
	//[self.view addSubview:_volumeVoiceSlider];
	
    if (indexPath.section == 0) {
        switch (indexPath.row)
        {
            case 0:
            {
                // 0
                //                [cell addSubview:_synthesizerUILabel];
                //                [cell addSubview:_synthesizerUISwitch];
                
                [cell addSubview:_bgVoiceLabel];
                [cell addSubview:_bgVoiceSwitch];
                break;
            }
                
            case 1:
            {
                [cell addSubview:_personVoiceLabel];
                [cell addSubview:_personVoiceText];
                break;
            }
                
            case 2:
            {
                // 2
                [cell addSubview:_speedVoiceLabel];
                [cell addSubview:_speedVoiceSlider];
                break;
            }
                
            case 3:
            {
                [cell addSubview:_volumeVoiceLabel];
                [cell addSubview:_volumeVoiceSlider];
                // 3
                break;
            }
            default:
                break;
        }
        
    }
    else if (indexPath.section == 1)
    {
        [cell addSubview: _personVoicePickerView];
    }
	
    return cell;
}
- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
	CGFloat height = 0;
	if (indexPath.section == 0)
	{
		height = 45;
	}
	else
	{
		height = 180;
	}
	return height;
}

- (NSString *)tableView:(UITableView *)tableView titleForHeaderInSection:(NSInteger)section
{
    NSString* sectionTitle = nil;
	switch (section)
	{
		case 1:
			sectionTitle = @"发音人";//@"类型";
			break;
	}
	return sectionTitle;
    
}
#pragma mark -
#pragma mark UIPickerViewDelegate

- (void)pickerView:(UIPickerView *)pickerView didSelectRow:(NSInteger)row inComponent:(NSInteger)component
{
	_selectRow = row;
    _personVoiceText.text = [_pickerViewArray objectAtIndex:_selectRow];
    [_iFlySynthesizerView setParameter:@"voice_name" value:[_VoiceNamearray objectAtIndex: _selectRow]];
}

#pragma mark -
#pragma mark UIPickerViewDataSource

// to realize the protocol
- (NSString *)pickerView:(UIPickerView *)pickerView titleForRow:(NSInteger)row forComponent:(NSInteger)component
{
	NSString *returnStr = @"";
	
	// note: custom picker doesn't care about titles, it uses custom views
	
	if (component == 0)
	{
		returnStr = [_pickerViewArray objectAtIndex:row];
	}
	else
	{
		returnStr = [[NSNumber numberWithInt:row] stringValue];
	}
	
	
	return returnStr;
}


- (CGFloat)pickerView:(UIPickerView *)pickerView widthForComponent:(NSInteger)component
{
	CGFloat componentWidth = 260.0;
	
	return componentWidth;
}

- (CGFloat)pickerView:(UIPickerView *)pickerView rowHeightForComponent:(NSInteger)component
{
	return 40.0;
}

- (NSInteger)pickerView:(UIPickerView *)pickerView numberOfRowsInComponent:(NSInteger)component
{
	return [_pickerViewArray count];
}

- (NSInteger)numberOfComponentsInPickerView:(UIPickerView *)pickerView
{
	return 1;
}
@end


