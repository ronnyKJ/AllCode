//
//  ModelPageData.m
//  futureTravel
//
//  Created by Stephen Moraco on 12/03/22.
//  Copyright (c) 2012 Iron Sheep Productions, LLC. All rights reserved.
//

#import "ModelPageData.h"

#pragma mark CLASS SyDetailStatusViewController - PRIVATE Interface

@interface ModelPageData () {
    
}

#pragma mark ---- PRIVATE Properties

@property (nonatomic, strong) NSString *filename;
@property (nonatomic, assign) NSUInteger pageNbr;
@property (nonatomic, assign) NSUInteger maxPages;

//#pragma mark ---- PRIVATE Methods

@end


#pragma mark - CLASS SyDevice - Implementation

@implementation ModelPageData

#pragma mark ---- Public Properties

@synthesize filename = m_strFilename;
@synthesize pageNbr = m_nPageNbr;
@synthesize maxPages = m_nMaxPages;

//#pragma mark ---- PRIVATE Properties

//#pragma mark ---- CLASS STATIC Methods


#pragma mark ---- Public Property setter/getter overrides

-(NSString *)pageTitle
{
    NSLog(@"- want pageTitle");
    return [NSString stringWithFormat:@"eFutureTravel v001, Pg %d of %d",self.pageNbr, self.maxPages];
}


#pragma mark ---- Public methods

-(id)initWithImageFileName:(NSString *)strFilename andPageNbr:(NSUInteger)nPageNbr ofMax:(NSUInteger)nMaxPageNbr
{
    self = [super init];
    if(self) {
        self.filename = strFilename;
        self.pageNbr = nPageNbr;
        self.maxPages = nMaxPageNbr;
    }
    return self;
}

//#pragma mark ---- PRIVATE (Utility) Methods



@end
