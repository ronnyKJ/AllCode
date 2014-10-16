//
//  BIDViewController.h
//  Button
//
//  Created by baidu on 13-11-24.
//  Copyright (c) 2013年 Zhangkejing. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface BIDViewController : UIViewController
@property (weak, nonatomic) IBOutlet UIButton *left;
@property (weak, nonatomic) IBOutlet UIButton *right;
@property (weak, nonatomic) IBOutlet UILabel *label;
@property (weak, nonatomic) IBOutlet UITextField *txt;
@property (strong, nonatomic) IBOutlet UIControl *portrait;
@property (strong, nonatomic) IBOutlet UIControl *landscape;
@property (weak, nonatomic) IBOutlet UIImageView *myimageview;

- (IBAction)press:(id)sender;
- (IBAction)finishTyping:(id)sender;
- (IBAction)backgroundTap:(id)sender;
- (IBAction)setImage:(id)sender;
@end
