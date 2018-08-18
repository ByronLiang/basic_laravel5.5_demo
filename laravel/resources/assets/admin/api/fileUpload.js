import FileUpload from 'common/helpers/FileUpload';
import {uploadToken} from './Cache';

export default class extends FileUpload {
    /**
     * 获取上传参数
     * @param drive
     * @returns {Promise<*>}
     */
    uploadParameter(drive) {
        if (drive) this.drive = drive;
        return uploadToken(this.drive);
    }
}
