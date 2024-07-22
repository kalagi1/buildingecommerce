import React, { useEffect, useRef, useState } from 'react';

const FileUploadV2 = ({setData,open}) => {
    const [selectedImage,setSelectedImage] = useState("");
    const fileInput = useRef(null)

    const handleClick = () => {
        fileInput.current.click()
    }

    const handleFileChange = (event) => {
        setData(event.target.files[0]);
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onloadend = () => {
              setSelectedImage(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }

    useEffect(() => {
        setSelectedImage("");
    },[open])

    return(
        <div>
            <input ref={fileInput} onChange={(e) => handleFileChange(e)} type="file" className='d-none' />
            <div onClick={() => handleClick()} className="file-upload-area">
                <svg width="79" height="67" viewBox="0 0 79 67" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M39.8497 25.3897V60.3002M39.8497 25.3897L51.3851 37.0265M39.8497 25.3897L28.3143 37.0265M60.9979 44.7844C66.8386 44.7844 70.6107 40.0094 70.6107 34.1173C70.6105 31.7846 69.8523 29.5162 68.4522 27.6596C67.0522 25.8031 65.0874 24.4607 62.8589 23.8381C62.5161 19.4877 60.7288 15.3811 57.786 12.1822C54.8432 8.98333 50.917 6.87918 46.6421 6.20992C42.3672 5.54066 37.9935 6.34542 34.228 8.49409C30.4626 10.6428 27.5256 14.0097 25.8918 18.0507C22.4521 17.0888 18.7744 17.5448 15.6679 19.3183C12.5614 21.0918 10.2805 24.0376 9.327 27.5076C8.37349 30.9776 8.82548 34.6876 10.5835 37.8214C12.3416 40.9552 15.2617 43.2562 18.7014 44.2181" stroke="#EA2B2E" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/> </svg>
                <span>Resim yüklemek için tıklayın , ya da resimi sürükleyip bu alana bırakın</span>
                <img src={selectedImage} alt="" />
            </div>
        </div>
    )
}

export default FileUploadV2