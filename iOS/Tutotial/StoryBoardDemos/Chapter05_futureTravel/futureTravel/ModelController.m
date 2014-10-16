//
//  ModelController.m
//  futureTravel
//
//  Created by Stephen Moraco on 12/03/31.
//  Copyright (c) 2012 Iron Sheep Productions, LLC. All rights reserved.
//

#import "ModelController.h"

#import "DataViewController.h"
#import "ModelPageData.h"

/*
  A controller object that manages a simple model -- a collection of ModelPageData objects.

 The controller serves as the data source for the page view controller; it therefore implements pageViewController:viewControllerBeforeViewController: and pageViewController:viewControllerAfterViewController:.
 It also implements a custom method, viewControllerAtIndex: which is useful in the implementation of the data source methods, and in the initial configuration of the application.
 
 There is no need to actually create view controllers for each page in advance -- indeed doing so incurs unnecessary overhead. Given the data model, these methods create, configure, and return a new view controller on demand.
 */

@interface ModelController() {
    
}

@property (readonly, strong, nonatomic) NSArray *pageData;

@end


@implementation ModelController

@synthesize pageData = _pageData;
@synthesize destinationNumber = m_nDestinationNumber; // [1-4]

enum {
    MAX_PAGES = 4
};

- (id)init
{
    self = [super init];
    if (self) {
        // Create the data model...
        
        // - set starting page
        self.destinationNumber = 1;   // set our default destination
        
        // - create the pages
        NSMutableArray *mpdPagesAr = [NSMutableArray array];
        
        ModelPageData *newPageDescription = [[ModelPageData alloc] initWithImageFileName:@"01-Intro.png" andPageNbr:1 ofMax:MAX_PAGES];
        [mpdPagesAr addObject:newPageDescription];
        
        newPageDescription = [[ModelPageData alloc] initWithImageFileName:@"02-Pick.png" andPageNbr:2 ofMax:MAX_PAGES];
        [mpdPagesAr addObject:newPageDescription];
        
        newPageDescription = [[ModelPageData alloc] initWithImageFileName:@"1-Aspect-1.png" andPageNbr:3 ofMax:MAX_PAGES];
        [mpdPagesAr addObject:newPageDescription];
        
        newPageDescription = [[ModelPageData alloc] initWithImageFileName:@"1-Aspect-2.png" andPageNbr:4 ofMax:MAX_PAGES];
        [mpdPagesAr addObject:newPageDescription];
        
        newPageDescription = [[ModelPageData alloc] initWithImageFileName:@"2-Aspect-1.png" andPageNbr:3 ofMax:MAX_PAGES];
        [mpdPagesAr addObject:newPageDescription];
        
        newPageDescription = [[ModelPageData alloc] initWithImageFileName:@"2-Aspect-2.png" andPageNbr:4 ofMax:MAX_PAGES];
        [mpdPagesAr addObject:newPageDescription];
        
        newPageDescription = [[ModelPageData alloc] initWithImageFileName:@"3-Aspect-1.png" andPageNbr:3 ofMax:MAX_PAGES];
        [mpdPagesAr addObject:newPageDescription];
        
        newPageDescription = [[ModelPageData alloc] initWithImageFileName:@"3-Aspect-2.png" andPageNbr:4 ofMax:MAX_PAGES];
        [mpdPagesAr addObject:newPageDescription];
        
        newPageDescription = [[ModelPageData alloc] initWithImageFileName:@"4-Aspect-1.png" andPageNbr:3 ofMax:MAX_PAGES];
        [mpdPagesAr addObject:newPageDescription];
        
        newPageDescription = [[ModelPageData alloc] initWithImageFileName:@"4-Aspect-2.png" andPageNbr:4 ofMax:MAX_PAGES];
        [mpdPagesAr addObject:newPageDescription];
        
        _pageData = [NSArray arrayWithArray:mpdPagesAr];
    }
    return self;
}

- (DataViewController *)viewControllerAtIndex:(NSUInteger)index storyboard:(UIStoryboard *)storyboard
{   
    // Return the data view controller for the given index.
    if (([self.pageData count] == 0) || (index >= MAX_PAGES)) {
        return nil;
    }
    
    // determine index into our 10 possible pages based on desired page and desired destination
    NSUInteger nObjectIdx = index;
    if(index > 1) {
        nObjectIdx += (self.destinationNumber - 1) * 2;
    }
    
    // Create a new view controller and pass suitable data.
    DataViewController *dataViewController = [storyboard instantiateViewControllerWithIdentifier:@"DataViewController"];
    dataViewController.dataObject = [self.pageData objectAtIndex:nObjectIdx];
    return dataViewController;
}

- (NSUInteger)indexOfViewController:(DataViewController *)viewController
{   
     // Return the index of the given data view controller.
    
    // determine the page index from our (object) index into our 10 possible pages 
    NSUInteger nObjectIdx = [self.pageData indexOfObject:viewController.dataObject];
    NSUInteger nIndex = nObjectIdx;
    if(nObjectIdx > 1) {
        nIndex -= (self.destinationNumber - 1) * 2;
    }
    return nIndex;
}

#pragma mark - Page View Controller Data Source

- (UIViewController *)pageViewController:(UIPageViewController *)pageViewController viewControllerBeforeViewController:(UIViewController *)viewController
{
    NSUInteger index = [self indexOfViewController:(DataViewController *)viewController];
    if ((index == 0) || (index == NSNotFound)) {
        return nil;
    }
    
    index--;
    return [self viewControllerAtIndex:index storyboard:viewController.storyboard];
}

- (UIViewController *)pageViewController:(UIPageViewController *)pageViewController viewControllerAfterViewController:(UIViewController *)viewController
{
    NSUInteger index = [self indexOfViewController:(DataViewController *)viewController];
    if (index == NSNotFound) {
        return nil;
    }
    
    index++;
    if (index == MAX_PAGES) {
        return nil;
    }
    return [self viewControllerAtIndex:index storyboard:viewController.storyboard];
}

@end
