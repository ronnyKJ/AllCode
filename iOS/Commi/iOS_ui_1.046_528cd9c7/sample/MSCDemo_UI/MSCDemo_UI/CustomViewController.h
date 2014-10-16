//
//  CustomViewController.h
//  MSC
//
//  Created by iflytek on 13-4-7.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "ABNFViewController.h"
#import "ContectViewController.h"
#import "ASRViewController.h"
#import "UserWordsViewController.h"

@interface CustomViewController : UITableViewController
{
    NSArray             *_contentArray;
    ContectViewController *_contectViewController;
    ASRViewController   *_asrViewController;
    UserWordsViewController *_userWordsViewController;
    ABNFViewController *_abnfViewController;
}

- (id) initWithStyle:(UITableViewStyle)style array:(NSArray *)array;

@end
