//
//  RootViewController.h
//  futureTravel
//
//  Created by Stephen Moraco on 12/03/31.
//  Copyright (c) 2012 Iron Sheep Productions, LLC. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "DataViewController.h"

@interface RootViewController : UIViewController <UIPageViewControllerDelegate, DataViewControllerDelegate> {
    
}

@property (strong, nonatomic) UIPageViewController *pageViewController;

@end
