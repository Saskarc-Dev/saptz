$(function(){


    // Reports
    $(document).on("click", "[name='rptLoad']", function(){
        var img = new Image(150, 210);
        img.src = '../assets/img/saskarc-logo.png';
        generatereport(getBase64Image(img));
    });

    function generatereport(imgUrl){
        console.log(imgUrl);
        var win = window.open('', '_blank');
        // var docDefinition = {
        //     content: [
        //         {
        //             layout: 'lightHorizontalLines', // optional
        //             table: 
        //             {
        //                 // headers are automatically repeated if the table spans over multiple pages
        //                 // you can declare how many rows should be treated as headers
        //                 headerRows: 1,
        //                 widths: [ '*', 'auto', 100, '*' ],
        //                 body: 
        //                 [
        //                     [ 'First', 'Second', 'Third', 'The last one' ],
        //                     [ 'Value 1', 'Value 2', 'Value 3', 'Value 4' ],
        //                     [ { text: 'Bold value', fontSize: 10 }, 'Val 2', 'Val 3', 'Val 4' ]
        //                 ]
        //             , style : 'tbl'}
        //         }
        //     ]
        // };

        var docDefinition = {
            header  : {text: 'Saskarc Production Report', fontSize: 24, alignment: 'center'},
            footer  : {
                columns : [
                    'Sample footer',
                    {text: 'Page No.', alignment: 'right'}
                ]
            },
            content : [
                {
                    image: imgUrl
                },
                {
                    layout: 'lightHorizontalLines', // optional
                    table: 
                    {
                        // headers are automatically repeated if the table spans over multiple pages
                        // you can declare how many rows should be treated as headers
                        headerRows: 2,
                        widths: [ '*', 'auto', 100, '*' ],
                        body: 
                        [
                            [ 'First', 'Second', 'Third', 'The last one' ],
                            [ 'Value 1', 'Value 2', 'Value 3', 'Value 4' ],
                            [ { text: 'Bold value', fontSize: 10 }, 'Val 2', 'Val 3', 'Val 4' ]
                        ]
                    }
                }
            ]
        }

        pdfMake.createPdf(docDefinition).open({}, win);        
    }

    function getBase64Image(img) {
        // Create an empty canvas element
        var canvas = document.createElement("canvas");
        canvas.width = img.width;
        canvas.height = img.height;
    
        // Copy the image contents to the canvas
        var ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0);
    
        // Get the data-URL formatted image
        // Firefox supports PNG and JPEG. You could check img.src to
        // guess the original format, but be aware the using "image/jpg"
        // will re-encode the image.
        var dataURL = canvas.toDataURL("image/jpg");
    
        return dataURL;
    }

});


