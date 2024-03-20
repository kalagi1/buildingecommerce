import React, { useRef, useState } from 'react'
function FileUpload({fileName,projectData,setProjectDataFunc,multiple,accept,document,title,setProjectData,allErrors}) {
    const inputRef = useRef();
    const [uploadingOrder,setUploadingOrder] = useState([[]]);
    const [imageLoading,setImageLoading] = useState(false);
    const [loadingImageCount,setLoadingImageCount] = useState(0);
    const [imagesLoadingHtml,setImagesLoadingHtml] = useState([]);
    const fileUpload = async (event) => {
        if(!document){
            if(multiple){
                const files = event.target.files;
                const tempImages = [];
                const tempImages2 = []; 
                setLoadingImageCount(files.length);
                loadingImageSkeletion(files.length);
                setImageLoading(true);
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    tempImages2.push(file);
                    const reader = new FileReader();
    
                    // FileReader.onload olayını bir Promise ile sarmalayarak işlemi bekleyebiliriz
                    if (file) {
                        const imageDataUrl = await new Promise((resolve) => {
                            reader.onload = () => {
                                setTimeout(() => resolve(reader.result), 1000); // Her resim yüklendiğinde 1 saniye bekleyin
                            };
                            reader.readAsDataURL(file); // Resmi oku
                        });
                        tempImages.push(imageDataUrl); // Geçici resimler dizisine ekle
                        setUploadingOrder([tempImages]);
                    }
                }
                setProjectData({
                    ...projectData,
                    [fileName+'_imagesx'] : tempImages,
                    [fileName] : tempImages2
                });

                setImageLoading(false);
            }else{
                const file = event.target.files[0];
                const reader = new FileReader();
        
                reader.onload = () => {
                    setProjectData({
                        ...projectData,
                        [fileName+'_imagex'] : reader.result,
                        [fileName] : file
                    });
                };

                
        
                if (file) {
                    reader.readAsDataURL(file);
                }
            }
        }else{
            const file = filesx[0];
            
            setProjectDataFunc(fileName,file)
        }
    }

    const fileUpload2 = async (filesx) => {
        if(!document){
            if(multiple){
                const files = filesx;
                const tempImages = [];
                const tempImages2 = []; 
                setLoadingImageCount(files.length);
                loadingImageSkeletion(files.length);
                setImageLoading(true);
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    tempImages2.push(file);
                    const reader = new FileReader();
    
                    // FileReader.onload olayını bir Promise ile sarmalayarak işlemi bekleyebiliriz
                    if (file) {
                        const imageDataUrl = await new Promise((resolve) => {
                            reader.onload = () => {
                                setTimeout(() => resolve(reader.result), 1000); // Her resim yüklendiğinde 1 saniye bekleyin
                            };
                            reader.readAsDataURL(file); // Resmi oku
                        });
                        tempImages.push(imageDataUrl); // Geçici resimler dizisine ekle
                        setUploadingOrder([tempImages]);
                    }
                }
                setProjectData({
                    ...projectData,
                    [fileName+'_imagesx'] : tempImages,
                    [fileName] : tempImages2
                });

                setImageLoading(false);
            }else{
                const file = filesx[0];
                const reader = new FileReader();
        
                reader.onload = () => {
                    setProjectData({
                        ...projectData,
                        [fileName+'_imagex'] : reader.result,
                        [fileName] : file
                    });
                };

                
        
                if (file) {
                    reader.readAsDataURL(file);
                }
            }
        }else{
            const file = filesx[0];
            
            setProjectDataFunc(fileName,file)
        }
    }

    const handleDrop = (e) => {
        e.preventDefault();
        const file = e.dataTransfer.files;
        fileUpload2(file);
    };

    const handleDragOver = (e) => {
        e.preventDefault();
    };

    const loadingImageSkeletion = (loadingImageCountx) => {
        var tempHtml = [];
        for(var i = 0; i < loadingImageCountx; i++){
            tempHtml.push(<div>asdasd</div>)
        }

        setImagesLoadingHtml(tempHtml);
    }
    console.log(imagesLoadingHtml);

    return(
        <div>
            <span className="section-title mt-4 housing_after_step">{title}</span>
            <div  onDrop={handleDrop} onDragOver={handleDragOver} className="cover-photo-full card py-2 px-5 housing_after_step">
                <input accept={accept} ref={inputRef} multiple={multiple} onChange={fileUpload} type="file" name="cover-image" className="cover_image d-none"/>
                <div onClick={() => {inputRef.current.click();}} id={fileName}  className={"upload-container col-md-4 col-xl-3 cover-photo-area "+(allErrors.includes(fileName) ? "error-border" : "")}>
                    <div className="border-container">
                        <div className="icons fa-4x">
                            <i className="fas fa-file-image" data-fa-transform="shrink-2 up-4"></i>
                        </div>
                        <p>Bilgisayardan {document ? "Dosya" : "Fotoğraf"} Ekle <span>veya sürükle bırak</span></p>
                    </div>
                </div>
                {
                    document ?
                        projectData[fileName] ?
                            <div class="cover-document">
                                <div class="has_file">
                                    <span class="d-block">Dosya Eklediniz</span>
                                    <a class="btn btn-info" href="https://emlaksepette.com/housing_documents/document_temp106.pdf" download="">Mevcut Dosyayı İndir</a>
                                </div>
                            </div>
                        : ''
                    :
                        imageLoading ?
                            <div>
                                <span className='d-block' style={{marginTop:'20px'}}>
                                    Yüklenen Resim Sayısı : {uploadingOrder[0].length} / {loadingImageCount}
                                </span>
                                <div className="cover-photo">
                                    {
                                        multiple ? 
                                            Array.from({ length: loadingImageCount }).map((_, imageIndex) => {
                                                const imageUrl = uploadingOrder[0]?.[imageIndex]; // Güvenli erişim işleci (?.) kullanarak hata kontrolü sağlanıyor
                                            
                                                if (imageUrl) {
                                                    return (
                                                        <div className="project_imagex">
                                                            <img src={imageUrl} />
                                                        </div>
                                                    );
                                                } else {
                                                    return (
                                                        <div className="project_imagex">
                                                            <span style={{display:'flex',justifyContent:'center',alignItems:'center',height:'100%'}}><i className='fa fa-spinner spinner-borderx'></i></span>
                                                        </div>
                                                    );
                                                }
                                            })
                                        : 
                                            ""
                                    } 
                                </div>
                            </div>
                        :
                            projectData[fileName+'_imagex'] || projectData[fileName+'_imagesx'] ?
                                <div className="cover-photo">
                                    {
                                        multiple ? 
                                            projectData[fileName+'_imagesx'].map((image,imageIndex) => {
                                                return (
                                                    
                                                    <div className="project_imagex">
                                                        <img src={image}/>

                                                        <div onClick={() => {removeImage(imageIndex)}} className="remove-area">
                                                            <i className='fa fa-trash'></i>
                                                        </div>
                                                    </div>
                                                )
                                            })
                                        : 
                                            <div className="project_imagex">
                                                <img src={projectData[fileName+'_imagex']}/>
                                            </div>
                                    }
                                </div>
                            : ''
                    
                    
                }
                
            </div>
        </div>
    )
}
export default FileUpload