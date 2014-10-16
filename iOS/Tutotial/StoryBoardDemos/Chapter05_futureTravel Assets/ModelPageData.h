//
//  ModelPageData.h
//  futureTravel
//
//  Created by Stephen Moraco on 12/03/22.
//  Copyright (c) 2012 Iron Sheep Productions, LLC. All rights reserved.
//

#import <Foundation/Foundation.h>

#pragma mark CLASS ModelPageData - PUBLIC Interface

@interface ModelPageData : NSObject {
    
}

#pragma mark ---- Public Properties

@property (nonatomic, strong, readonly) NSString *filename;
@property (nonatomic, assign, readonly) NSUInteger pageNbr;
@property (nonatomic, assign, readonly) NSUInteger maxPages;
@property (nonatomic, strong, readonly) NSString *pageTitle;

#pragma mark ---- Public Methods

-(id)initWithImageFileName:(NSString *)strFilename andPageNbr:(NSUInteger)nPageNbr ofMax:(NSUInteger)nMaxPageNbr;

@end
