package com.bootdo.epaper.service;

import com.bootdo.epaper.domain.PaperDO;

import java.util.List;
import java.util.Map;

/**
 * 
 * 
 * @author hzw
 * @email hao17681124518@163.com
 * @date 2018-12-11 21:48:48
 */
public interface PaperService {
	
	PaperDO get(Long id);
	
	List<PaperDO> list(Map<String, Object> map);
	
	int count(Map<String, Object> map);
	
	int save(PaperDO paper);
	
	int update(PaperDO paper);
	
	int remove(Long id);
	
	int batchRemove(Long[] ids);

	int getLastPublishID();
}
