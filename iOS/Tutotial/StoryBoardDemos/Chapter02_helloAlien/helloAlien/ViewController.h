//
//  ViewController.h
//  helloAlien
//
//  Created by Rory Lewis on 12/26/11.
//  Copyright (c) 2011 University of Colorado at Colorado Springs. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "AlienViewController.h"

@interface ViewController : UIViewController <AlienViewControllerDelegate>

@property (weak, nonatomic) IBOutlet UILabel *lblFindStatus;
@property (strong, nonatomic) NSString *alienText;

@end
