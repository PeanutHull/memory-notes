1. 没有判断Redis.Nil
1. gorm的updates和get没有加where
1. gorilla/websocket的WriteMessage方法没有用sync.Mutex保护，偶现的并发WriteMessage会导致panic
1. sync.Mutex不支持读锁升级写锁(都不支持，会导致问题)，不能在defer RUnlock没执行呢，就要Lock
    ```go
    // BroadcastToClient 广播消息给指定客户端
    func (d *WebSocketDispatcher) BroadcastToClient(clientId int, messageType int, message []byte) error {
        d.mu.RLock()
        defer d.mu.RUnlock()
        if conn, ok := d.connections[clientId]; ok {
            if err := conn.WriteMessage(messageType, message); err != nil {                                     // 这里需要加锁，最佳实践是用结构体包裹*websocket.Conn和sync.Mutex，二者一块用
                log.Printf("向客户端 %d 发送消息出错: %v", clientId, err)
                d.Stop(clientId)
                return err
            }
            return nil
        }
        return fmt.Errorf("客户端 %d 不存在", clientId)
    }

    // Stop 停止与特定客户端的连接
    func (d *WebSocketDispatcher) Stop(clientId int) {
        d.mu.Lock()                                                                                             // 这里会fatal error
        defer d.mu.Unlock()
        if stopCh, ok := d.stopChans[clientId]; ok {
            close(stopCh)                 // 关闭该客户端的独立停止通道
            delete(d.stopChans, clientId) // 删除该客户端的通道
        }
        if conn, ok := d.connections[clientId]; ok {
            _ = conn.Close()                // 关闭 WebSocket 连接
            delete(d.connections, clientId) // 从 connections 中移除客户端
        }
    }
    ```