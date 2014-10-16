//
//  BIDViewController.m
//  Button
//
//  Created by baidu on 13-11-24.
//  Copyright (c) 2013年 Zhangkejing. All rights reserved.
//

#import "BIDViewController.h"
#define degreesToRadians(x) (M_PI * (x) / 180.0)

@interface BIDViewController ()

@end

@implementation BIDViewController



- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
    
    UIImageView *headview = [[UIImageView alloc] initWithFrame:CGRectMake(0, 0, 140, 140)];
    NSURL *photourl = [NSURL URLWithString:@"http://avatar.csdn.net/8/F/4/1_mad1989.jpg"];
    //url请求实在UI主线程中进行的
    UIImage *images = [UIImage imageWithData:[NSData dataWithContentsOfURL:photourl]];
    headview.image = images;
    [self.view addSubview:headview];
    
    self.myimageview.image = images;
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (IBAction)press:(id)sender {
    _label.text = _right.titleLabel.text;
}

- (IBAction)finishTyping:(id)sender {
    [sender resignFirstResponder];
}

- (IBAction)backgroundTap:(id)sender {
    [self.txt resignFirstResponder];
}

- (IBAction)setImage:(id)sender {
    NSURL *photourl = [NSURL URLWithString:@"http://avatar.csdn.net/8/F/4/1_mad1989.jpg"];
    //url请求实在UI主线程中进行的
    UIImage *images = [UIImage imageWithData:[NSData dataWithContentsOfURL:photourl]];
    self.myimageview.image = images;
}

- (void)willAnimateRotationToInterfaceOrientation:(UIInterfaceOrientation) interfaceOrientation duration:(NSTimeInterval)duration
{
    if (interfaceOrientation == UIInterfaceOrientationPortrait) {
        self.view = self.portrait;
        self.view.transform = CGAffineTransformIdentity;
        self.view.transform = CGAffineTransformMakeRotation(degreesToRadians(0));
        self.view.bounds = CGRectMake(0.0, 0.0, 320.0, 460.0);
        
    }else if (interfaceOrientation == UIInterfaceOrientationLandscapeLeft) {
        self.view = self.landscape;
        self.view.transform = CGAffineTransformIdentity;
        self.view.transform = CGAffineTransformMakeRotation(degreesToRadians(-90));
        self.view.bounds = CGRectMake(0.0, 0.0, 480.0, 300.0);
        
    }else if (interfaceOrientation == UIInterfaceOrientationLandscapeRight) {
        self.view = self.landscape;
        self.view.transform = CGAffineTransformIdentity;
        self.view.transform = CGAffineTransformMakeRotation(degreesToRadians(90));
        self.view.bounds = CGRectMake(0.0, 0.0, 480.0, 300.0);
    }
}
@end
