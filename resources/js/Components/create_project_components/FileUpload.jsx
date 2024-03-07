import React, { useRef, useState } from 'react'
function FileUpload({fileName,projectData,setProjectDataFunc,multiple,accept,document,title,setProjectData}) {
    const inputRef = useRef();
    const [loading,setLoading] = useState(false);

    const fileUpload = async (event) => {
        if(!document){
            if(multiple){
                const files = event.target.files;
                const tempImages = []; // Geçici resimler dizisi
                const tempImages2 = []; // Geçici resimler dizisi
    
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    tempImages2.push(file);
                    const reader = new FileReader();
    
                    // FileReader.onload olayını bir Promise ile sarmalayarak işlemi bekleyebiliriz
                    const loadPromise = new Promise((resolve) => {
                        reader.onload = () => {
                            resolve(reader.result);
                        };
                    });
    
                    if (file) {
                        reader.readAsDataURL(file); // Resmi oku
                        const imageDataUrl = await loadPromise; // Resim yüklendiğinde Promise tamamlanana kadar bekler
                        tempImages.push(imageDataUrl); // Geçici resimler dizisine ekle
                    }
                }
                
                setProjectData({
                    ...projectData,
                    [fileName+'_imagesx'] : tempImages,
                    [fileName] : tempImages2
                });
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

    return(
        <div>
            <span className="section-title mt-4 housing_after_step">{title}</span>
            <div className="cover-photo-full card py-2 px-5 housing_after_step">
                <input accept={accept} ref={inputRef} multiple={multiple} onChange={fileUpload} type="file" name="cover-image" className="cover_image d-none"/>
                <div onClick={() => {inputRef.current.click();}}  className="upload-container col-md-4 col-xl-3 cover-photo-area">
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
                        loading ?
                            <div className='fa fa-spinner'></div>
                        :
                            projectData[fileName+'_imagex'] || projectData[fileName+'_imagesx'] ?
                                <div className="cover-photo">
                                    {
                                        multiple ? 
                                            projectData[fileName+'_imagesx'].map((image) => {
                                                return (
                                                    
                                                    <div className="project_imagex">
                                                        <img src={image}/>
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