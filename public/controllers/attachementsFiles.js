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

let ad = FilePond.create(
    document.querySelector('#edit_trick_picture'),
    {
        acceptedFileTypes: ['image/*'],
        storeAsFile: true,
    }
);

let bd = FilePond.create(
    document.querySelector('#edit_trick_bg_img'), {
        acceptedFileTypes: ['image/*'],
        storeAsFile: true,
    }
);

let cd = FilePond.create(
    document.querySelector('#edit_trick_images'), {
        acceptedFileTypes: ['image/*'],
        storeAsFile: true,
    }
);


function imageRemover(id)
{
    document.getElementById("attach" + id).style.position = 'absolute';
    document.getElementById("att" + id).checked = false;
    document.getElementById("ci" + id).remove();
}

function bgRemover()
{
    document.getElementById("edit_trick_edit_bg_img").checked = false;
    document.getElementById("cibg").remove();
    const input = [...document.querySelectorAll(".filepond--browser")].filter(node => node.name === "edit_trick[bg_img]")[0]
    input.innerHTML = input.innerHTML.substr(0,input.innerHTML.length - 1 ) + " enabled>"
}

function pictureRemover()
{
    document.getElementById("edit_trick_edit_picture").checked = false;
    document.getElementById("cipr").remove();
    const input = [...document.querySelectorAll(".filepond--browser")].filter(node => node.name === "edit_trick[picture]")[0]
    input.setAttribute("required", true);
}