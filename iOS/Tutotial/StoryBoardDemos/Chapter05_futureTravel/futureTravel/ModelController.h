//
//  ModelController.h
//  futureTravel
//
//  Created by Stephen Moraco on 12/03/31.
//  Copyright (c) 2012 Iron Sheep Productions, LLC. All rights reserved.
//

#import <UIKit/UIKit.h>

@class DataViewController;

@interface ModelController : NSObject <UIPageViewControllerDataSource> {
    
}

@property (nonatomic, assign) NSUInteger destinationNumber; // number [1-4] for selected destination

- (DataViewController *)viewControllerAtIndex:(NSUInteger)index storyboard:(UIStoryboard *)storyboard;
- (NSUInteger)indexOfViewController:(DataViewController *)viewController;

@end
