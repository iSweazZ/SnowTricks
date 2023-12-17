FilePond.registerPlugin(

    // encodes the file as base64 data
    FilePondPluginFileEncode,

    // validates the size of the file
    FilePondPluginFileValidateSize,

    // corrects mobile image orientation
    FilePondPluginImageExifOrientation,

    // previews dropped images
    FilePondPluginImagePreview
);

// Select the file input and use create() to turn it into a pond
let a = FilePond.create(
    document.querySelector('#trick_bg_img'),
    {
        acceptedFileTypes: ['image/*'],
        storeAsFile: true,
    }
);

let b = FilePond.create(
    document.querySelector('#trick_picture'), {
        acceptedFileTypes: ['image/*'],
        storeAsFile: true,
    }
);

let c = FilePond.create(
    document.querySelector('#trick_images'), {
        acceptedFileTypes: ['image/*'],
        storeAsFile: true,
    }
);