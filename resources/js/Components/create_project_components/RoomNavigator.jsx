import React, { useEffect, useState } from 'react'
function RoomNavigator({selectedRoom,setSelectedRoom,blocks,setBlocks,selectedBlock,formData,validationErrors,setValidationErrors}) {
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
                    if(blocks[selectedBlock]?.rooms[selectedRoom][formData[i].name] && blocks[selectedBlock]?.rooms[selectedRoom][formData[i].name] != "" && blocks[selectedBlock]?.rooms[selectedRoom][formData[i].name] != "Seçiniz"){
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
                tempItems2.push({
                    label : blocks[i].name +' '+ (j+1) +' No\'lu Konut',
                    value : i+"-"+j
                })
            }
        }

        setTempItems(tempItems2)
    },[selectedBlock])

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
        
        setBlocks(newBlocks);
        
        setCopyLoading(true);
    }

    const allCopy = () => {
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
    }

    return(
        <div className="bottom-housing-area align-center col-xl-6 col-md-6 col-6" style={{justifyContent:'center'}}>
            {
                copyLoading ?
                    <div className='copy-loading-area'><div className="load-area"></div></div>
                : ''
            }
            <div className="row w-100">
                <div className="col-md-12 mbpx-10">
                    <div className="row jc-space-between">
                        <div className="col-md-5">
                            <div className="d-flex" style={{alignItems:'center'}}>
                                <div className="show-houing-order " style={{width:'calc(100% - 30px)'}}>
                                    <div className="full-load" style={{width:percentOccupancy()+'%'}}></div>
                                     <span>Daire <span className="room-order-progress">1</span> / <span className="percent-housing">{percentOccupancy().toFixed(2)}</span>%</span></div>
                                <div className="icon" style={{marginLeft:'5px'}} data-toggle="tooltip" data-placement="top" title="Doldurduğunuz konutun doluluk oranını görüntüleyebilirsiniz">
                                    <i className="fa fa-circle-info"></i>
                                </div>
                            </div>
                        </div>
                        <div className="col-md-2">
                            <button className='btn btn-primary' onClick={allCopy}>Hepsine Kopyala</button>
                        </div>
                        <div className="col-md-5">
                            <div className="d-flex" style={{alignItems:'center'}}>
                                <div className="icon" style={{marginRight:'5px'}}>
                                    <i className="fa fa-circle-info"></i>
                                </div>
                                
                                <select value={copyValue} onChange={(e) => {var copyValues= e.target.value.split('-'); copyItem(copyValues[0],copyValues[1])}} className={"form-control  copy-item"} name="" id="">
                                    <option value="">Kopyalamak istediğiniz daireyi seçin</option>
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