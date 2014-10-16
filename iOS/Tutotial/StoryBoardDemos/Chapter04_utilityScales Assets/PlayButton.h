//
//  PlayButton.h
//  utiltyScales
//
//  Created by Stephen Moraco on 12/01/18.
//  Copyright (c) 2012 Iron Sheep Productions, LLC. All rights reserved.
//

#import <UIKit/UIKit.h>

#pragma mark ---- Forward Declarations

@protocol PlayButtonDelegate;

#pragma mark - PlayButton Interface Declaration

@interface PlayButton : UIViewController {
    
}

#pragma mark ---- Properties

@property (nonatomic, readonly, getter = isAcoustic) BOOL acoustic;
@property (nonatomic, assign, getter = isShowingPlay) BOOL showPlay;
@property (nonatomic, assign, getter = isHidden) BOOL hidden;
@property (nonatomic, weak) id<PlayButtonDelegate> delegate;
@property (nonatomic, assign) CGPoint center;

#pragma mark ---- Instance Methods

-(id)initWithIsAcoustic:(BOOL)isAcoustic;
-(CALayer *)layer;

@end

#pragma mark - <PlayButtonDelegate> Protocol Declaration

@protocol PlayButtonDelegate <NSObject>
@required
-(void)playButtonPressed:(PlayButton *)sender;

@end