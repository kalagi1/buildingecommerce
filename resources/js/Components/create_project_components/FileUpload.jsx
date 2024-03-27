import React, { useRef, useState } from 'react'
import { ReactSortable } from 'react-sortablejs';
import { toast } from 'react-toastify';


function FileUpload({fileName,projectData,setProjectDataFunc,multiple,accept,document,title,setProjectData,allErrors}) {
    const inputRef = useRef();
    const [uploadingOrder,setUploadingOrder] = useState([[]]);
    const [imageLoading,setImageLoading] = useState(false);
    const [loadingImageCount,setLoadingImageCount] = useState(0);
    const fileUpload = async (event) => {
        if(!document){
            if(multiple){
                const files = event.target.files;
                const tempImages = [];
                const tempImages2 = []; 
                setLoadingImageCount(files.length);
                setImageLoading(true);
                var lastImageCount = projectData[fileName+'_imagesx'] ? projectData[fileName+'_imagesx'].length : 0;
                if((lastImageCount + files.length) <= 40){
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
                    if(projectData[fileName+'_imagesx']){
                        setProjectData({
                            ...projectData,
                            [fileName+'_imagesx'] : [...projectData[fileName+'_imagesx'], ...tempImages],
                            [fileName] : [...projectData[fileName], ...tempImages2]
                        });
                    }else{
                        setProjectData({
                            ...projectData,
                            [fileName+'_imagesx'] : [...tempImages],
                            [fileName] : [...tempImages2]
                        });
                    }
                }else{
                    toast.error("Toplam resim sayısı 40'ı geçiyor. Lütfen resim sayısı sınırına dikkat edin")
                }

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
            const file = event.target.files[0];
            
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
                if(projectData[fileName+'_imagesx']){
                    setProjectData({
                        ...projectData,
                        [fileName+'_imagesx'] : [...projectData[fileName+'_imagesx'], ...tempImages],
                        [fileName] : [...projectData[fileName], ...tempImages2]
                    });
                }else{
                    setProjectData({
                        ...projectData,
                        [fileName+'_imagesx'] : [...tempImages],
                        [fileName] : [...tempImages2]
                    });
                }
                
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

    const changeArrayValues = (array, index1, index2) => {
        const tempArray = [...array]; // Orjinal dizinin kopyasını al
        const valueToMove = tempArray[index2]; // Taşınacak değeri al
        tempArray.splice(index2, 1); // İlk indeksten değeri çıkar
        tempArray.splice(index1, 0,valueToMove); // İlk indeksten değeri çıkar
        return tempArray;
    };

    const removeImage = (imageIndex) => {
        console.log(projectData[fileName+'_imagesx'],projectData[fileName],projectData,fileName,fileName+'_imagesx')
        var newImages = projectData[fileName+'_imagesx'].filter((image,imageOrder) => {
            return imageIndex != imageOrder
        })
        var newImages2 = projectData[fileName].filter((image,imageOrder) => {
            return imageIndex != imageOrder
        })
        
        setProjectData({
            ...projectData,
            [fileName+'_imagesx'] : newImages,
            [fileName] : newImages2
        });
    }

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
                        projectData[fileName+'_imagex'] || projectData[fileName+'_imagesx'] || imageLoading ?
                            <div>
                                {
                                    multiple ? 
                                        <span className='d-block badge badge-phoenix badge-phoenix-success inline-block' style={{marginTop:'20px'}}>
                                            Yüklenen Resim Sayısı : {(projectData[fileName+'_imagesx'] ? projectData[fileName+'_imagesx'].length : 0) + (imageLoading ? uploadingOrder[0].length : 0 )} / 40
                                        </span>
                                    : ''
                                }
                                <div className="cover-photo">
                                    {
                                        multiple ? 
                                            <>
                                                {
                                                    projectData[fileName+'_imagesx'] ? 
                                                        <ReactSortable
                                                            animation={200}
                                                            swap
                                                            list={projectData[fileName+'_imagesx']}
                                                            onSort={(e) => {
                                                                var newList = changeArrayValues(projectData[fileName+'_imagesx'],e.newIndex,e.oldIndex)
                                                                var newList2 = changeArrayValues(projectData[fileName],e.newIndex,e.oldIndex)
                                                                setProjectData({
                                                                    ...projectData,
                                                                    [fileName+'_imagesx'] : newList,
                                                                    [fileName] : newList2
                                                                });
                                                            }}
                                                            setList={() => {
                                                                console.log("asd");
                                                            }}
                                                        >
                                                            {
                                                                projectData[fileName+'_imagesx'].map((image,imageIndex) => {
                                                                    return (
                                                                        <div className="project_imagex">
                                                                            <img src={image} />
                                                                            <div onClick={() => {removeImage(imageIndex)}} className="remove-area">
                                                                                <i className='fa fa-trash'></i>
                                                                            </div>
                                                                        </div>
                                                                    )
                                                                })
                                                            }
                                                        </ReactSortable>
                                                    : ''
                                                }
                                                {
                                                    imageLoading ?
                                                        <div>
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
                                                    : ""
                                                }
                                            </>
                                        : 
                                            <div className="project_imagex">
                                                <img src={projectData[fileName+'_imagex']}/>
                                            </div>
                                    }
                                </div>
                            </div>
                        : ''
                    
                    
                }
                
            </div>
        </div>
    )
}
export default FileUpload