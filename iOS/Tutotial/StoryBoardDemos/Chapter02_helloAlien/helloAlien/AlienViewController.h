//
//  AlienViewController.h
//  helloAlien
//
//  Created by Rory Lewis on 12/26/11.
//  Copyright (c) 2011 University of Colorado at Colorado Springs. All rights reserved.
//

#import <UIKit/UIKit.h>

@protocol AlienViewControllerDelegate;

@interface AlienViewController : UIViewController
{
    @private
    BOOL m_bIsAlienSeen;
}

@property (weak, atomic) id<AlienViewControllerDelegate> delegate;
@property (strong, atomic) NSString *messageForAlien;
@property (weak, nonatomic) IBOutlet UILabel *lblmessageForAlien;

- (IBAction)onSwitchValueChanged:(id)sender;


@end

@protocol AlienViewControllerDelegate <NSObject>

@required
// alien identifies itself as existing
-(void)alien:(AlienViewController *)view saysIAmHere:(BOOL)bIsHere;

@end
