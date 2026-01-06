# T08
# 整合式海洋智慧監控與決策平台 (Integrated Marine Intelligence Platform)
本研究採取系統開發與原型建構法，建置一個名為 marine_platform 的海洋污染管理平台。該系統以 CRUD (新增、讀取、更新、刪除) 邏輯為核心，並整合模擬 AI 技術進行通報處理。
以下整理其實施步驟：
## 一、 環境與基礎建設 (Infrastructure Setup)
資料庫連線配置：首先透過 db.php 建立系統與資料庫之間的核心連線設定，確保資料能正確存取。
檔案存儲空間準備：建立 uploads/ 資料夾，並將權限設為可寫入，用以存放使用者上傳的污染照片。
## 二、 身份驗證與導航介面 (Authentication & Navigation)
入口與權限管理：開發 index.php 作為登入頁面與系統入口，並實作 logout.php 處理登出邏輯。
共用元件開發：製作 navbar.php 導覽列，以便在不同頁面間進行快速切換與功能引導。
## 三、 核心功能開發 (Core Functionalities)
本階段依據通報流程實作四大功能：
通報建立與 AI 模擬 (Create)：透過 report_create.php 供使用者上傳資料，並於此步驟執行模擬 AI 分析。
資料讀取與呈現 (Read)：開發 report_list.php 提供通報列表檢視，並建置 dashboard.php 儀表板以顯示統計數據。
進度更新與調度 (Update)：利用 report_edit.php 進行污染處理進度的更新與相關資源的調度管理。
資料移除 (Delete)：實作 report_delete.php 以執行移除不再需要的資料紀錄。
<img width="2752" height="1536" alt="image" src="https://github.com/user-attachments/assets/2f12f9f9-eaa1-4277-9de0-fb34adb81315" />
