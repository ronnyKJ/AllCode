//
//  AlertView.m
//  MSCDemo
//
//  Created by hchuang on 13-9-25.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import "AlertView.h"
#import <QuartzCore/QuartzCore.h>
@implementation AlertView
@synthesize ParentView = _parentView;
- (id)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    if (self) {
        self.backgroundColor = [[UIColor blackColor] colorWithAlphaComponent: 0.75f];
        self.layer.cornerRadius = 5.0f;
        _textLabel = [[UILabel alloc] initWithFrame:CGRectMake(0, 10, 100, 10)];
        _textLabel.numberOfLines = 0;
        _textLabel.font = [UIFont systemFontOfSize:17];
        _textLabel.textColor = [UIColor whiteColor];
        _textLabel.textAlignment = UITextAlignmentCenter;
        _textLabel.backgroundColor = [UIColor clearColor];
        _textLabel.textAlignment = UITextAlignmentCenter;
        [self addSubview:_textLabel];
        
        // Create and add the activity indicator  
        _aiv = [[UIActivityIndicatorView alloc] initWithActivityIndicatorStyle:UIActivityIndicatorViewStyleWhiteLarge];    
        [_aiv startAnimating];  
        [self addSubview:_aiv];    
        _queueCount = 0;
    }
    return self;
}

- (void) setText:(NSString *) text
{
    _textLabel.frame = CGRectMake(0, 10, 100, 10);
    self.alpha = 1.0f;
    _textLabel.text = text;
    [_textLabel sizeToFit];
    CGRect frame = CGRectMake(5, 0, _textLabel.frame.size.width, _textLabel.frame.size.height);
    _textLabel.frame = frame;
    _textLabel.frame = CGRectMake(_textLabel.frame.origin.x+40, _textLabel.frame.origin.y+10, _textLabel.frame.size.width, _textLabel.frame.size.height);
    frame =  CGRectMake((_parentView.frame.size.width - (frame.size.width+10+45))/2, self.frame.origin.y, _textLabel.frame.size.width+10+45, _textLabel.frame.size.height+20);
    _aiv.center = CGPointMake(25, _textLabel.bounds.size.height);
    self.frame = frame;
}

-(void) dismissModalView
{
    [self removeFromSuperview];
}

- (void) dealloc
{
    [_parentView release];
    [_aiv release];
    [super dealloc];
}

@end
