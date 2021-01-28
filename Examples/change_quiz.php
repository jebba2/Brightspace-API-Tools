<?php

require("./config/d2l_functions.php");


//JSON Structure - https://docs.valence.desire2learn.com/res/quiz.html

{
    "Name": <string>,
    "IsActive": <boolean>,
    "SortOrder": <number>,
    "AutoExportToGrades": <boolean>|null,
    "GradeItemId": <number:D2LID>|null,
    "IsAutoSetGraded": <boolean>,
    "Instructions": {
        "Text": { <composite:RichTextInput> },
        "IsDisplayed": <boolean>
    },
    "Description": {
        "Text": { <composite:RichTextInput> },
        "IsDisplayed": <boolean>
    },
    "StartDate": <string:UTCDateTime>|null,
    "EndDate": <string:UTCDateTime>|null,
    "DueDate": <string:UTCDateTime>|null,
    "DisplayInCalendar": <boolean>,
    "NumberOfAttemptsAllowed": <number>|null,  // Added with LE API v1.39
    "LateSubmissionInfo": {  // Added with LE API v1.39
        "LateSubmissionOption": <number:LATESUBMISSIONOPTION_T>,
        "LateLimitMinutes": <number>|null
    },
    "SubmissionTimeLimit": {  // Added with LE API v1.39
        "IsEnforced": <boolean>,
        "ShowClock": <boolean>,
        "TimeLimitValue": <number>
    },
    "SubmissionGracePeriod": <number>|null,  // Added with LE API v1.39
    "Password": <string>,  // Added with LE API v1.39
    "Header": {  // Added with LE API v1.39
        "Text": { <composite:RichTextInput> },
        "IsDisplayed": <boolean>
    },
    "Footer": {  // Added with LE API v1.39
        "Text": { <composite:RichTextInput> },
        "IsDisplayed": <boolean>
    },
    "AllowHints": <boolean>,  // Added with LE API v1.39
    "DisableRightClick": <boolean>,  // Added with LE API v1.39
    "DisablePagerAndAlerts": <boolean>,  // Added with LE API v1.39
    "NotificationEmail": <string>,  // Added with LE API v1.39
    "CalcTypeId": <number:OverallGradeCalculation_T>,  // Added with LE API v1.39
    "RestrictIPAddressRange": null|[  // Added with LE API v1.39
        {
            "IPRangeStart": <string>,
            "IPRangeEnd": <string>|null
        }, ...
    ],
    "CategoryId": <number>|null,  // Added with LE API v1.40
    "PreventMovingBackwards": <boolean>,  // Added with LE API v1.43
    "Shuffle": <boolean>,  // Added with LE API v1.43
    "AllowOnlyUsersWithSpecialAccess": <boolean>,  // Added with LE API v1.47
    "IsRetakeIncorrectOnly": <boolean> // Added with LE API v1.50
}


var_dump(d2l_put_quiz(OrgUnitId,QuizId,JSON));


?>