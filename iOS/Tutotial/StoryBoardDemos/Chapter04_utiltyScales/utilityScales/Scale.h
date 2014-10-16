//
//  Scale.h
//  guitarScales
//
//  Created by Stephen Moraco on 11/21/11.
//  Copyright (c) 2012 Iron Sheep Productions, LLC. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <AudioToolbox/AudioToolbox.h>

enum eScaleType {
    ST_UNKNOWN,
    ST_MAJOR_PENTATONIC_1ST_MODE,
    ST_MAJOR_PENTATONIC_2ND_MODE,
    ST_MIXOLYDIAN,
    ST_MINOR_PENTATONIC_5TH_MODE_OF_MAJOR,
    ST_BLUES_MINOR_HEXATONIC,
    ST_DOMINANT_BEBOP,
    ST_AELIOAN,
    ST_PHRYGIAN_DOMINANT,
};

@interface Scale : NSObject {
    // no protected/public instance variables
}

#pragma mark ---- Properties

@property (strong, atomic) NSString *title;
@property (strong, atomic) NSString *description;
@property (readwrite, atomic) enum eScaleType type;


#pragma mark ---- Instance Methods

-(id)initWithTitle:(NSString *)strTitle description:(NSString *)strDescription type:(enum eScaleType)eType audioFileBase:(NSString *)strAudioFilebase imageBasename:(NSString *)strImageFileBasename;

- (UIImage *)imageForElectricScale;
- (UIImage *)imageForAcousticScale;

- (NSString *)acousticScaleFilespec;
- (NSString *)electricScaleFilespec;

@end
