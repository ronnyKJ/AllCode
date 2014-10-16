//
//  Scale.m
//  guitarScales - combine scale attributes into single object
//
//  Created by Stephen Moraco on 11/21/11.
//  Copyright (c) 2012 Iron Sheep Productions, LLC. All rights reserved.
//

#import "Scale.h"

#pragma mark Scale PRIVATE Interface

@interface Scale () {
@private    // redundant, but docuemnts what we are doing
    
    // private instance variables
	SystemSoundID m_ssElectricScale;
	SystemSoundID m_ssAcousticScale;
}

// PRIVATE properties
@property (strong, atomic) NSString *audioFilenameBase;
@property (strong, atomic) NSString *imageFileBasename;

@end

#pragma mark - Scale Implementation

@implementation Scale

#pragma mark ---- Properties Public

@synthesize title;
@synthesize description;
@synthesize type;

#pragma mark ---- Properties PRIVATE

@synthesize audioFilenameBase;  // without "[electric|acoustic].m4a" suffix
@synthesize imageFileBasename;  // without .png suffix

#pragma mark ---- Instance Methods

-(id)initWithTitle:(NSString *)strTitle description:(NSString *)strDescription type:(enum eScaleType)eType audioFileBase:(NSString *)strAudioFilebase imageBasename:(NSString *)strImageFileBasename
{
    if(self = [super init])
    {
        self.title = strTitle;
        self.description = strDescription;
        self.type = eType;
        self.audioFilenameBase = strAudioFilebase;
        self.imageFileBasename = strImageFileBasename;
    }
    return self;
}

- (UIImage *)imageForElectricScale
{
    UIImage *image = [UIImage imageNamed:imageFileBasename];
    return image;  
}

- (UIImage *)imageForAcousticScale
{
    // create the filename
    NSString *strAcousticImageName = [NSString stringWithFormat:@"%@ Acoustic",imageFileBasename];
    // load the image
    UIImage *image = [UIImage imageNamed:strAcousticImageName];
    // return it to caller
    return image;  
}

- (NSString *)acousticScaleFilespec
{
    // create the filename
    NSString *strFileBasename = [NSString stringWithFormat:@"%@ acoustic",audioFilenameBase];
    NSLog(@"locating [%@]",strFileBasename);
    // determine the file system path to the sound to play.
	NSString *soundFileSpec = [[NSBundle mainBundle] pathForResource:strFileBasename ofType:@"m4a"];
    // return it to caller
	return soundFileSpec;
}

- (NSString *)electricScaleFilespec
{
    // create the filename
    NSString *strFileBasename = [NSString stringWithFormat:@"%@ electric",audioFilenameBase];
    NSLog(@"locating [%@]",strFileBasename);
    // determine the file system path to the sound to play.
	NSString *soundFileSpec = [[NSBundle mainBundle] pathForResource:strFileBasename ofType:@"m4a"];
    // return it to caller
	return soundFileSpec;
}

@end
