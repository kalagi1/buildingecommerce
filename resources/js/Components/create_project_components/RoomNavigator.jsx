import React, { useEffect, useState } from 'react'
import { toast } from 'react-toastify';
function RoomNavigator({formDataHousing,selectedRoom,setSelectedRoom,blocks,setBlocks,selectedBlock,formData,validationErrors,setValidationErrors,haveBlock}) {
    const [copyValue,setCopyValue] = useState("");
    const [tempItems,setTempItems] = useState([]);
    const [copyLoading,setCopyLoading] = useState(false);
    const nextHouse = () => {
        if(selectedRoom + 1 < blocks[selectedBlock]?.roomCount){
            const errors = [];
            for(var i = 0; i < formData.length; i++){
                if(!formData[i]?.className?.includes("project-disabled")){
                    if(formData[i].required){
                        if(blocks[selectedBlock]?.rooms[selectedRoom][formData[i].name] && blocks[selectedBlock]?.rooms[selectedRoom][formData[i].name] != "" && blocks[selectedBlock]?.rooms[selectedRoom][formData[i].name] != "Seçiniz"){
                        }else{
                            errors.push(formData[i].name)
                        }
                    }
                }
            }
            if(errors.length == 0){
                if(!blocks[selectedBlock].rooms[selectedRoom + 1]){
                    var newBlocks = blocks[selectedBlock].rooms;
                    newBlocks.push({});
                    setBlocks((block,key) => {
                        if(key == selectedBlock){
                            return {
                                ...block,
                                rooms : [...newBlocks]
                            }
                        }else{
                            return block;
                        }
                    })
                    setSelectedRoom(selectedRoom + 1);
                }else{
                    setSelectedRoom(selectedRoom + 1);
                }
            }else{
                
                if(document.getElementsByClassName('error-border').length > 0){
                    window.scrollTo({ top: document.getElementsByClassName('error-border')[0].offsetTop, behavior: "smooth" })
                    console.log("asd",document.getElementsByClassName('error-border')[0],document.getElementsByClassName('error-border')[0].offset);
                }
                setValidationErrors(errors);
            }
        }
    }


    const percentOccupancy = () => {
        var requiredCount = 0;
        var rightCount = 0;
        for(var i = 0; i < formData.length; i++){
            if(!formData[i]?.className?.includes("project-disabled")){
                if(formData[i].required){
                    requiredCount++;
                    if(blocks[selectedBlock]?.rooms[selectedRoom] && blocks[selectedBlock]?.rooms[selectedRoom][formData[i].name] && blocks[selectedBlock]?.rooms[selectedRoom][formData[i].name] != "" && blocks[selectedBlock]?.rooms[selectedRoom][formData[i].name] != "Seçiniz"){
                        rightCount++;
                    }
                }
            }
        }
        return (100 * rightCount) / requiredCount;
    }

    

    useEffect(() => {
        var tempItems2 = [];
        for(var i = 0; i < blocks.length; i++){
            for(var j = 0 ; j < blocks[i].roomCount; j++){
                if(haveBlock){
                    tempItems2.push({
                        label : blocks[i].name +' '+ (j+1) +' No\'lu Konut',
                        value : i+"-"+j
                    })
                }else{
                    if(j < selectedRoom){
                        tempItems2.push({
                            label : (j+1) +' No\'lu Konut',
                            value : i+"-"+j
                        })
                    }
                }
                
            }
        }

        setTempItems(tempItems2)
    },[selectedBlock,selectedRoom])

    const copyItem = (selectBlock,selectRoom) => {
        setCopyLoading(false);
        var newBlocks = blocks.map((block,key) => {
            if(key == selectedBlock){
                return {
                    ...block,
                    rooms : block.rooms.map((room,keyx) => {
                        if(keyx == selectedRoom){
                            return blocks[selectBlock].rooms[selectRoom];
                        }else{
                            return room;
                        }
                    })
                }
            }else{
                return block;
            }
        })

        if(haveBlock){
            toast.success(blocks[selectBlock].name+" bloğun "+(parseInt(selectRoom) + 1)+" nolu konutu "+blocks[selectedBlock].name+" bloğun "+(selectedRoom + 1)+" nolu konutuna kopyalandı")
        }else{
            
            toast.success((parseInt(selectRoom) + 1)+" nolu konut "+(selectedRoom + 1)+" nolu konuta kopyalandı")
        }
        
        setBlocks(newBlocks);
        
        setCopyLoading(true);
    }

    const allCopy = () => {
        var tempErrors = [];
        if(blocks.length > 0){
            formDataHousing.forEach((formDataHousing) => {
                if(!formDataHousing.className.includes('project-disabled')){
                    if(formDataHousing.required){
                        if(blocks.length < 1){
                            tempErrors.push(formDataHousing.name.replace("[]",""))
                        }else{
                            if(!blocks[selectedBlock].rooms[selectedRoom][formDataHousing.name]){
                                tempErrors.push(formDataHousing.name.replace("[]",""))
                            }
                        }
                        
                    }
                }
            })
        }

        if(tempErrors.length > 0){
            toast.error("Bu konutta zorunlu tüm alanlar dolu olmadığı için tüm konutlara kopyalama işlemi yapılamaz");
        }else{
            var tempBlocks = blocks.map((block) => {
                var tempRooms = [];
                for( var i = 0 ; i < block.roomCount; i++){
                    tempRooms.push(blocks[selectedBlock].rooms[selectedRoom]);
                }
    
                return {
                    ...block,
                    rooms : tempRooms
                }
            })

            setBlocks(tempBlocks);

            toast.success("Bu konutu başarıyla tüm konutlara kopyaladınız")
        }
        
    }

    return(
        <div className="bottom-housing-area align-center col-xl-6 col-md-6 col-6" style={{justifyContent:'center'}}>
            
            <div className="row w-100">
                <div className="col-md-12 mbpx-10">
                    <div className="row jc-space-between">
                        <div className="col-md-4">
                            <div className="d-flex" style={{alignItems:'center'}}>
                                <div className="show-houing-order " style={{width:'calc(100% - 30px)'}}>
                                    <div className="full-load" style={{width:percentOccupancy()+'%'}}></div>
                                     <span>Konut <span className="room-order-progress">{selectedRoom + 1}</span> / <span className="percent-housing">{percentOccupancy().toFixed(2)}</span>%</span></div>
                                <div className="icon" style={{marginLeft:'5px'}} data-toggle="tooltip" data-placement="top" title="Doldurduğunuz konutun doluluk oranını görüntüleyebilirsiniz">
                                    <i className="fa fa-circle-info"></i>
                                </div>
                            </div>
                        </div>
                        <div className="col-md-4">
                            <button className='btn btn-primary' onClick={allCopy}> Bu Konutu Hepsine Kopyala</button>
                        </div>
                        <div className="col-md-4">
                            <div className="d-flex" style={{alignItems:'center'}}>
                                <div className="icon" style={{marginRight:'5px'}}>
                                    <i className="fa fa-circle-info"></i>
                                </div>
                                
                                <select value={copyValue} onChange={(e) => {var copyValues= e.target.value.split('-'); copyItem(copyValues[0],copyValues[1])}} className={"form-control  copy-item"} name="" id="">
                                    <option value="">{
                                        haveBlock ? 
                                        "Kopyalamak istediğiniz konutu seçin" : selectedRoom == 0 ? "Kopyalama işlemi için 2 nolu konuta geçin" : "Kopyalamak istediğiniz konutu seçin" 
                                    }</option>
                                    {tempItems.map((x, i) => {
                                        return(
                                           <option value={x.value}>{x.label}</option>
                                        )
                                    })}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-md-12 ">
                    <div className="row" style={{justifyContent:'space-between'}}>
                        <div className=" col-md-4">
                            <div onClick={() => {selectedRoom != 0 ? setSelectedRoom(selectedRoom - 1) : () => {}}} className={"button-white prev-house-bottom "+(selectedRoom == 0 ? "disabled-button" : "")}>
                                <i className="fa fa-circle-chevron-left"></i> <span className="ml-5px last-housing-text">Önceki Konut</span>
                            </div>
                        </div>
                        <div className="button-white2 col-md-4">
                            <input type="text" value={selectedRoom + 1} className="form-control house_order_input"/><span>/</span><span className="total-house-text">{blocks[selectedBlock]?.roomCount}</span>
                        </div>
                        <div className="col-md-4">
                            <div className={"button-white next-house-bottom "+(selectedRoom == blocks[selectedBlock]?.roomCount - 1 ? "disabled-button" : "")} onClick={() => {nextHouse()}}>
                                <span className="mr-5px next-housing-text">Sonraki Konut</span> <i className="fa fa-circle-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}
export default RoomNavigator