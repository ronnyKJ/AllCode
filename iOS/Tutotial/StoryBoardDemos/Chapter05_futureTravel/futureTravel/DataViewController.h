//
//  DataViewController.h
//  futureTravel
//
//  Created by Stephen Moraco on 12/03/31.
//  Copyright (c) 2012 Iron Sheep Productions, LLC. All rights reserved.
//

#import <UIKit/UIKit.h>

@protocol DataViewControllerDelegate;

@interface DataViewController : UIViewController {
    
}

@property (strong, nonatomic) IBOutlet UILabel *dataLabel;
@property (weak, nonatomic) IBOutlet UIImageView *ivPageImage;
@property (strong, nonatomic) id dataObject;
@property (weak, nonatomic) id<DataViewControllerDelegate> delegate;

@end


@protocol DataViewControllerDelegate <NSObject>

@required
-(void)dataViewControllerSelectedDestination:(NSUInteger)destinationNumber;

@end
